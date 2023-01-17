<?php

namespace Elogic\Certificate\Controller\Adminhtml\Subject;

use Elogic\Certificate\Api\Data\SubjectInterfaceFactory;
use Elogic\Certificate\Api\SubjectRepositoryInterface;
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
     * @var SubjectInterfaceFactory
     */
    private SubjectInterfaceFactory $subjectFactory;
    /**
     * @var SubjectRepositoryInterface
     */
    private SubjectRepositoryInterface $subjectRepository;

    /**
     * @param Context $context
     * @param RedirectFactory $redirectFactory
     * @param SubjectInterfaceFactory $subjectFactory
     * @param SubjectRepositoryInterface $subjectRepository
     */
    public function __construct(
        Context                         $context,
        RedirectFactory                 $redirectFactory,
        SubjectInterfaceFactory         $subjectFactory,
        SubjectRepositoryInterface      $subjectRepository
    ){
        parent::__construct($context);
        $this->subjectFactory = $subjectFactory;
        $this->subjectRepository = $subjectRepository;
        $this->redirectFactory = $redirectFactory;
    }

    /**
     * @return Redirect
     * @throws LocalizedException
     */
    public function execute(): Redirect
    {
        $redirectResult = $this->redirectFactory->create();
        $subject = $this->subjectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if (!$data['general']['subject_id']) {
            $data['general']['subject_id'] = null;
        } else {
            $subject->setId($data['general']['subject_id']);
        }
        $subject->setSubject($data['general']['subject']);
        $this->subjectRepository->save($subject);

        $redirectResult->setPath('*/*/index');
        return $redirectResult;
    }
}
