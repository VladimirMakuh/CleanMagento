<?php

namespace Elogic\Certificate\Controller\Adminhtml\Subject;

use Elogic\Certificate\Api\Data\SubjectInterfaceFactory;
use Elogic\Certificate\Api\SubjectRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Edit Subject entity backend controller.
 */
class Edit extends Action
{
    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;
    /**
     * @var SubjectInterfaceFactory
     */
    protected SubjectInterfaceFactory $subjectFactory;
    /**
     * @var SubjectRepositoryInterface
     */
    protected SubjectRepositoryInterface $subjectRepository;

    /**
     * @param Context $context
     * @param SubjectInterfaceFactory $subjectFactory
     * @param SubjectRepositoryInterface $subjectRepository
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context                         $context,
        SubjectInterfaceFactory         $subjectFactory,
        SubjectRepositoryInterface      $subjectRepository,
        PageFactory                     $resultPageFactory
    ){
        $this->subjectRepository = $subjectRepository;
        $this->subjectFactory = $subjectFactory;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @return Redirect|ResultInterface|Page
     */
    public function execute()
    {
        $subjectId = (int)$this->getRequest()->getParam('subject_id');

        $subjectTitle = "Subject";
        if ($subjectId) {
            $subjectTitle = $this->subjectFactory->create()->getName();
            $subject = $this->subjectRepository->getById($subjectId);
            if (!$subject->getId()) {
                $this->messageManager->addErrorMessage(__('No subject with that id'));
                return $this->resultRedirectFactory->create()->setPath('*/*/');
            }
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu("Elogic_Certificate::certificate");
        $resultPage->getConfig()->getTitle()->prepend(__($subjectTitle));
        $resultPage->addHandle('subject' . $subjectId);
        return $resultPage;

    }
}
