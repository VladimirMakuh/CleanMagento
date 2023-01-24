<?php

namespace Elogic\Certificate\Controller\Adminhtml\Certificate;

use Elogic\Certificate\Api\Data\CertificateInterface;
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

        if (!$data['general'][CertificateInterface::CERTIFICATE_ID]) {
            $data['general'][CertificateInterface::CERTIFICATE_ID] = null;
        } else {
            $certificate->setCertificateId($data['general'][CertificateInterface::CERTIFICATE_ID]);
        }
        $certificate->setCertificateId($data['general'][CertificateInterface::CERTIFICATE_ID]);
        $certificate->setTypeId($data['general'][CertificateInterface::TYPE_ID]);
        $certificate->setCertNumber($data['general'][CertificateInterface::CERT_NUMBER]);
        $certificate->setSubjectId($data['general'][CertificateInterface::SUBJECT_ID]);
        $certificate->setStudentName($data['general'][CertificateInterface::STUDENT_NAME]);
        $certificate->setStudentSurname($data['general'][CertificateInterface::STUDENT_SURNAME]);
        $certificate->setDateValid($data['general'][CertificateInterface::DATE_VALID]);
        $certificate->setSignature($data['general'][CertificateInterface::SIGNATURE]);

        $this->certificateRepository->save($certificate);

        $redirectResult = $this->redirectFactory->create();

        $redirectResult->setPath('*/*/index');
        return $redirectResult;
    }
}
