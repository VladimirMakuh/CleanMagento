<?php

namespace Elogic\Certificate\Controller\Adminhtml\Type;

use Elogic\Certificate\Api\Data\TypeInterfaceFactory;
use Elogic\Certificate\Api\TypeRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Exception\LocalizedException;

class Save extends Action
{
    /**
     * @var RedirectFactory
     */
    private RedirectFactory $redirectFactory;
    /**
     * @var TypeInterfaceFactory
     */
    private TypeInterfaceFactory $typeFactory;
    /**
     * @var TypeRepositoryInterface
     */
    private TypeRepositoryInterface $typeRepository;

    /**
     * @param Context $context
     * @param RedirectFactory $redirectFactory
     * @param TypeInterfaceFactory $typeFactory
     * @param TypeRepositoryInterface $typeRepository
     */
    public function __construct(
        Context                    $context,
        RedirectFactory            $redirectFactory,
        TypeInterfaceFactory       $typeFactory,
        TypeRepositoryInterface    $typeRepository
    ){
        parent::__construct($context);
        $this->typeFactory = $typeFactory;
        $this->typeRepository = $typeRepository;
        $this->redirectFactory = $redirectFactory;
    }

    /**
     * @return Redirect
     * @throws LocalizedException
     */
    public function execute(): Redirect
    {
        $type = $this->typeFactory->create();
        $data = $this->getRequest()->getPostValue();

        if (!$data['general']['type_id']) {
            $data['general']['type_id'] = null;
        } else {
            $type->setId($data['general']['type_id']);
        }
        $type->setType($data['general']['type']);
        $this->typeRepository->save($type);

        $redirectResult = $this->redirectFactory->create();

        $redirectResult->setPath('*/*/index');
        return $redirectResult;
    }
}
