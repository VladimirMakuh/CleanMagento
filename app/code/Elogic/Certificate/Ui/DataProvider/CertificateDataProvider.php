<?php
declare(strict_types=1);

namespace Elogic\Certificate\Ui\DataProvider;

use Elogic\Certificate\Api\Data\CertificateInterface;
use Elogic\Certificate\Query\Certificate\GetListQuery;
use Elogic\Certificate\Helper\CertNumber;
use Exception;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;
use Magento\Ui\DataProvider\SearchResultFactory;

/**
 * DataProvider component.
 */
class CertificateDataProvider extends DataProvider
{
    /**
     * @var GetListQuery
     */
    private GetListQuery $getListQuery;

    /**
     * @var SearchResultFactory
     */
    private SearchResultFactory $searchResultFactory;

    /**
     * @var CertNumber
     */
    private CertNumber $certNumber;
    /**
     * @var array
     */
    private array $loadedData = [];

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param ReportingInterface $reporting
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param RequestInterface $request
     * @param FilterBuilder $filterBuilder
     * @param GetListQuery $getListQuery
     * @param SearchResultFactory $searchResultFactory
     * @param CertNumber $certNumber
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        GetListQuery $getListQuery,
        SearchResultFactory $searchResultFactory,
        CertNumber $certNumber,
        array $meta = [],
        array $data = []
    ){
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
        $this->certNumber = $certNumber;
        $this->getListQuery = $getListQuery;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * Returns searching result.
     *
     * @return SearchResultInterface
     */
    public function getSearchResult()
    {
        $searchCriteria = $this->getSearchCriteria();
        $result = $this->getListQuery->execute($searchCriteria);

        return $this->searchResultFactory->create(
            $result->getItems(),
            $result->getTotalCount(),
            $searchCriteria,
            CertificateInterface::CERTIFICATE_ID
        );
    }

    /**
     * Get data.
     *
     * @return array
     * @throws Exception
     */
    public function getData(): array
    {
        if ($this->loadedData) {
            return $this->loadedData;
        }
        $this->loadedData = parent::getData();
        if(!$this->loadedData['items'])
        {
            $this->loadedData['items'][0][CertificateInterface::CERTIFICATE_ID] = 0;
            $this->loadedData['items'][0][CertificateInterface::CERT_NUMBER] = $this->certNumber->getCertificatedNumber();
        }
        $itemsById = [];

        foreach ($this->loadedData['items'] as $item) {
            $itemsById[(int)$item[CertificateInterface::CERTIFICATE_ID]] = $item;
        }

        if ($id = $this->request->getParam(CertificateInterface::CERTIFICATE_ID)) {
            $this->loadedData['entity'] = $itemsById[(int)$id];
        }

        return $this->loadedData;
    }
}
