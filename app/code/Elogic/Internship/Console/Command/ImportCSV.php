<?php

/**
 *  For use run command in console BASH mode:
 * php bin/magento import:storelocator:csv -p 1location.csv
 *
 */

namespace Elogic\Internship\Console\Command;

use Elogic\Internship\Api\Data\StoreLocatorInterfaceFactory;
use Elogic\Internship\Api\StoreLocatorRepositoryInterface;
use Elogic\Internship\Api\GeoCodeInterface;
use Exception;
use Magento\Framework\File\Csv;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCSV extends Command
{
    /**
     * @var StoreLocatorInterfaceFactory
     */
    protected StoreLocatorInterfaceFactory $storeLocatorFactory;
    /**
     * @var Csv
     */
    protected Csv $csv;
    /**
     * @var GeoCodeInterface
     */
    protected GeoCodeInterface $geoCode;
    /**
     * @var StoreLocatorRepositoryInterface
     */
    protected StoreLocatorRepositoryInterface $storeLocatorRepository;


    /**
     * @param StoreLocatorInterfaceFactory $storeLocatorFactory
     * @param Csv $csv
     * @param GeoCodeInterface $geoCode
     * @param StoreLocatorRepositoryInterface $storeLocatorRepository
     */
    public function __construct(
        StoreLocatorInterfaceFactory    $storeLocatorFactory,
        Csv                             $csv,
        GeoCodeInterface                $geoCode,
        StoreLocatorRepositoryInterface $storeLocatorRepository
    ){
        $this->storeLocatorFactory = $storeLocatorFactory;
        $this->csv = $csv;
        $this->geoCode = $geoCode;
        $this->storeLocatorRepository = $storeLocatorRepository;
        parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('import:storelocator:csv');
        $this->setDescription('Import stores from csv to DB');
        $this->addOption('path', "p", InputOption::VALUE_OPTIONAL, "Path for csv file");
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $path = $input->getOption('path');

        if (empty($path)) {
            throw  new \RuntimeException("Invalid argument");
        }

        try {
            $csvData = fopen($path, 'rb');

            $counter = 1;
            $keys = fgetcsv($csvData);
            while ($row = fgetcsv($csvData)) {
                $store = $this->storeLocatorFactory->create();
                $data = array_combine($keys, $row);

                // Get Coordinates
                if (!empty($data['position'])) {
                    $coordinates = explode(",", $data['position']);
                } else {
                    $coordinates = $this->geoCode->getCoordinates($data['country'] . ', ' . $data['city'] . ', ' . $data['address']);
                    // set value
                    $store->setLongitude($coordinates[1]);
                    $store->setLatitude($coordinates[0]);
                }
                $store->setName($data['name']);
                $store->setAddress($data['country'] . ', ' . $data['city'] . ', ' . $data['address']);
                $store->setDescription($data['description']);
                $store->setImage($data['store_img']);
                $store->setUrl($data['url_key']);
                $this->storeLocatorRepository->save($store);
                unset($store);

                echo "Store $counter saved \n";
                $counter++;
            }
        } catch (Exception $e) {
            $output->writeln('Invalid CSV');
            $output->writeln($e->getMessage());
        }
        //test comment
    }
}
