<?php
declare(strict_types=1);

namespace Elogic\Certificate\Controller\Adminhtml\Type;

use Elogic\Certificate\Api\Data\TypeInterfaceFactory;
use Elogic\Certificate\Api\TypeRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\ResponseInterface;

class Delete extends Action
{
    protected $resultFactory;
    protected  $resultRedirectFactory;
    /**
     * @var TypeInterfaceFactory
     */
    protected TypeInterfaceFactory $typeFactory;
    /**
     * @var TypeRepositoryInterface
     */
    protected TypeRepositoryInterface $typeRepository;

    /**
     * @param Context $context
     * @param TypeInterfaceFactory $typeFactory
     * @param TypeRepositoryInterface $typeRepository
     * @param RedirectFactory $resultRedirectFactory
     */
    public function __construct(
        Context                         $context,
        TypeInterfaceFactory         $typeFactory,
        TypeRepositoryInterface      $typeRepository,
        RedirectFactory                 $resultRedirectFactory
    ){
        $this->resultFactory = $resultRedirectFactory;
        $this->typeRepository = $typeRepository;
        $this->typeFactory = $typeFactory;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('type_id');

        $this->typeRepository->deleteById((int)$id);
        $this->messageManager->addSuccessMessage(__('Type have been deleted.'));
        $result = $this->resultRedirectFactory->create();
        $result->setPath('elogic/type/index');

        return $result;
    }
}
