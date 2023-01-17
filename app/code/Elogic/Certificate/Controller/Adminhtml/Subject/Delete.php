<?php
declare(strict_types=1);

namespace Elogic\Certificate\Controller\Adminhtml\Subject;

use Elogic\Certificate\Api\Data\SubjectInterfaceFactory;
use Elogic\Certificate\Api\SubjectRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;

class Delete extends Action
{
    protected $resultFactory;
    protected  $resultRedirectFactory;
    /**
     * @var SubjectInterfaceFactory
     */
    protected SubjectInterfaceFactory $storeFactory;
    /**
     * @var SubjectRepositoryInterface
     */
    protected SubjectRepositoryInterface $storeRepository;

    /**
     * @param Context $context
     * @param SubjectInterfaceFactory $storeFactory
     * @param SubjectRepositoryInterface $storeRepository
     * @param RedirectFactory $resultRedirectFactory
     */
    public function __construct(
        Context                         $context,
        SubjectInterfaceFactory         $storeFactory,
        SubjectRepositoryInterface      $storeRepository,
        RedirectFactory                 $resultRedirectFactory
    ){
        $this->resultFactory = $resultRedirectFactory;
        $this->storeRepository = $storeRepository;
        $this->storeFactory = $storeFactory;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('subject_id');

        $this->storeRepository->deleteById((int)$id);
        $this->messageManager->addSuccessMessage(__('Subject have been deleted.'));
        $result = $this->resultRedirectFactory->create();
        $result->setPath('elogic/subject/index');

        return $result;
    }
}
