<?php

declare(strict_types=1);

namespace Elogic\Internship\Controller\Adminhtml\StoreLocator;

use Elogic\Internship\Api\Data\StoreLocatorInterface;
use Elogic\Internship\Api\Data\StoreLocatorInterfaceFactory;
use Elogic\Internship\Api\StoreLocatorRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Exception\LocalizedException;

class Save extends Action
{
    /**
     * @var RedirectFactory
     */
    private RedirectFactory $redirectFactory;

    /**
     * @var StoreLocatorInterfaceFactory
     */
    private StoreLocatorInterfaceFactory $storeLocatorFactory;
    /**
     * @var StoreLocatorRepositoryInterface
     */
    private StoreLocatorRepositoryInterface $storeRepository;
    /**
     * @var ImageUploader
     */
    private ImageUploader $imageUploader;
    /**
     * @var Json
     */
    private Json $json;

    /**
     * @param Context $context
     * @param RedirectFactory $redirectFactory
     * @param StoreLocatorInterfaceFactory $storeLocatorFactory
     * @param StoreLocatorRepositoryInterface $storeRepository
     * @param ImageUploader $imageUploader
     * @param Json $json
     */
    public function __construct(
        Context                         $context,
        RedirectFactory                 $redirectFactory,
        StoreLocatorInterfaceFactory    $storeLocatorFactory,
        StoreLocatorRepositoryInterface $storeRepository,
        ImageUploader                   $imageUploader,
        Json                            $json
    ){
        parent::__construct($context);
        $this->storeLocatorFactory = $storeLocatorFactory;
        $this->storeRepository = $storeRepository;
        $this->imageUploader = $imageUploader;
        $this->redirectFactory = $redirectFactory;
        $this->json = $json;
    }

    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     * @throws LocalizedException
     */
    public function execute()
    {
        $redirectResult = $this->redirectFactory->create();
        $store = $this->storeLocatorFactory->create();
        $data = $this->getRequest()->getPostValue();

        if (!$data['store_entity_id']) {
            $data['store_entity_id'] = null;
        } else {
            $store->setId($data['store_entity_id']);
        }
        $store->setName($data['name']);
        $store->setDescription($data['description']);
        $store->setAddress($data['address']);
        $store->setLatitude($data['latitude']);
        $store->setLongitude($data['longitude']);
        $store = $this->setImage($data, $store);
        $store = $this->setSchedule($data, $store);
        $store->setUrl($data['store_url_key']);
        $this->storeRepository->save($store);

        $redirectResult->setPath('*/*/index');
        return $redirectResult;
    }

    /**
     * @param $data
     * @param $store
     * @return StoreLocatorInterface
     * @throws LocalizedException
     */
    public function setImage($data, $store): StoreLocatorInterface
    {
        if (isset($data['image'][0]['name']) && isset($data['image'][0]['tmp_name'])) {
            $data['image'] = $data['image'][0]['name'];
            $this->imageUploader->moveFileFromTmp($data['image']);
        } elseif (isset($data['image'][0]['name']) && !isset($data['image'][0]['tmp_name'])) {
            $data['image'] = $data['image'][0]['name'];
        } else {
            $data['image'] = '';
        }
        $store->setImage($data['image']);
        return $store;
    }

    /**
     * @param $data
     * @param $store
     * @return StoreLocatorInterface
     */
    public function setSchedule($data, $store): StoreLocatorInterface
    {

        if (isset($data['schedule'])) {
            $store->setSchedule($this->json->serialize($data['schedule']));
        }
        return $store;
    }
}
