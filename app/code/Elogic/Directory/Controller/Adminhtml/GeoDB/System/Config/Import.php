<?php
declare(strict_types=1);

namespace Elogic\Directory\Controller\Adminhtml\GeoDB\System\Config;

use Elogic\Directory\Model\Config\CityConfigProvider;
use Elogic\Directory\Api\Data\CityInterfaceFactory;
use Elogic\Directory\Api\CityRepositoryInterface;
use Elogic\Directory\Api\CityAcquirerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Message\ManagerInterface;

class Import implements HttpGetActionInterface
{
    /**
     * @var RedirectFactory
     */
    private RedirectFactory $redirect;
    /**
     * @var CityConfigProvider
     */
    private CityConfigProvider $config;
    /**
     * @var ManagerInterface
     */
    private ManagerInterface $messageManager;
    /**
     * @var CityInterfaceFactory
     */
    private CityInterfaceFactory $cityFactory;
    /**
     * @var CityRepositoryInterface
     */
    private CityRepositoryInterface $cityRepository;
    /**
     * @var CityAcquirerInterface
     */
    private CityAcquirerInterface $cityResource;

    /**
     * @param RedirectFactory $resultRedirectFactory
     * @param CityConfigProvider $configProvider
     * @param ManagerInterface $manager
     * @param CityInterfaceFactory $cityFactory
     * @param CityRepositoryInterface $cityRepository
     * @param CityAcquirerInterface $cityAcquirer
     */
    public function __construct(
        RedirectFactory         $resultRedirectFactory,
        CityConfigProvider      $configProvider,
        ManagerInterface        $manager,
        CityInterfaceFactory    $cityFactory,
        CityRepositoryInterface $cityRepository,
        CityAcquirerInterface   $cityAcquirer

    ){
        $this->redirect = $resultRedirectFactory;
        $this->config = $configProvider;
        $this->messageManager = $manager;
        $this->cityFactory = $cityFactory;
        $this->cityRepository = $cityRepository;
        $this->cityResource = $cityAcquirer;
    }

    /**
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->redirect->create();

        $this->import();

        return $resultRedirect->setRefererUrl();
    }

    /**
     * Import cities from GeoDB and save it to database
     *
     * @return void
     */
    private function import(): void
    {
        $cities = $this->getCitiesGeo();

        if($cities === null)
        {
            $this->messageManager->addErrorMessage(__('Something went wrong, try again'));
            return;
        }

        $count = count($cities->data);

        foreach ($cities->data as $city) {

            // if city is unique, save it to database
            if($this->cityResource->checkUniqueCity($city->city))
            {
                $cityData = $this->cityFactory->create();
                $cityData->setCountry($city->country);
                $cityData->setCity($city->city);
                $cityData->setIso2Code($city->countryCode);
                $this->cityRepository->save($cityData);
                unset($cityData);
            }
            $count--;
        }

        if($count === 0)
        {
            $this->messageManager->addSuccessMessage(__('The cities was successfully imported'));
        }
    }

    /**
     * Get cities using GeoDB Cities API
     */
    private function getCitiesGeo()
    {
        $client = new Client([
            'base_uri' => 'https://wft-geo-db.p.rapidapi.com/v1/',
            'headers' => [
                'x-rapidapi-key' =>  $this->config->getApiKey(),
                'x-rapidapi-host' => $this->config->getApiHost()
            ]
        ]);

        try {
            $response = $client->request('GET','geo/cities');

            return json_decode($response->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);
        } catch (GuzzleException|\JsonException $e) {
            return $e;
        }
    }
}
