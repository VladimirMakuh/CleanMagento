<?php

namespace Elogic\Internship\Ui\Component\StoreLocator\Listing\Column;

use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\TestFramework\Inspection\Exception;
use Magento\Ui\Component\Listing\Columns\Column;

class Schedule extends Column
{
    /**
     * @var Json
     */
    private Json $json;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Json $json
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface   $context,
        UiComponentFactory $uiComponentFactory,
        Json               $json,
        array              $components = [],
        array              $data = []
    ){
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->json = $json;
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                try {
                    if ($item['schedule'] !== "") {
                        $schedule = $this->json->unserialize($item['schedule']);
                        foreach ($schedule as $temp) {
                            if (!isset($tmp)) {
                                $tmp = "day \"" . $temp['day'] . "\" - from \"" . $temp['from'] . "\" to \"" . $temp['to'] . "\",  ";
                            } else {
                                $tmp = $tmp . "day \"" . $temp['day'] . "\" - from \"" . $temp['from'] . "\" to \"" . $temp['to'] . "\" \r\n";
                            }
                            $item['schedule'] = $tmp;
                        }
                    }
                } catch (Exception $exception) {
                }
            }
        }
        return $dataSource;
    }
}
