<?php

namespace Elogic\Certificate\Controller\Adminhtml\Certificate;

use Elogic\Certificate\Api\Data\CertificateInterfaceFactory;
use Elogic\Certificate\Api\CertificateRepositoryInterface;
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
     * @var CertificateInterfaceFactory
     */
    private CertificateInterfaceFactory $certificateFactory;
    /**
     * @var CertificateRepositoryInterface
     */
    private CertificateRepositoryInterface $certificateRepository;

    /**
     * @param Context $context
     * @param RedirectFactory $redirectFactory
     * @param CertificateInterfaceFactory $certificateFactory
     * @param CertificateRepositoryInterface $certificateRepository
     */
    public function __construct(
        Context                    $context,
        RedirectFactory            $redirectFactory,
        CertificateInterfaceFactory       $certificateFactory,
        CertificateRepositoryInterface    $certificateRepository
    ){
        parent::__construct($context);
        $this->certificateFactory = $certificateFactory;
        $this->certificateRepository = $certificateRepository;
        $this->redirectFactory = $redirectFactory;
    }

    /**
     * @return Redirect
     * @throws LocalizedException
     */
    public function execute(): Redirect
    {
        $certificate = $this->certificateFactory->create();
        $data = $this->getRequest()->getPostValue();

        if (!$data['general']['certificate_id']) {
            $data['general']['certificate_id'] = null;
        } else {
            $certificate->setCertificateId($data['general']['certificate_id']);
        }
        $certificate->setTypeId($data['general']['type_id']);
        $certificate->setSubjectId($data['general']['subject_id']);
        $certificate->setStudentName($data['general']['student_name']);
        $certificate->setStudentSurName($data['general']['student_surname']);
        $certificate->setDateValid($data['general']['date_valid']);
        $certificate->setSignature($data['general']['signature']);

        $this->certificateRepository->save($certificate);

        $redirectResult = $this->redirectFactory->create();

        $redirectResult->setPath('*/*/index');
        return $redirectResult;
    }
}
