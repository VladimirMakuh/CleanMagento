<?php
declare(strict_types=1);

namespace Elogic\Certificate\Controller\Adminhtml\Certificate;

use Elogic\Certificate\Api\Data\CertificateInterfaceFactory;
use Elogic\Certificate\Api\CertificateRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Edit Certificate entity backend controller.
 */
class Edit extends Action
{
    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;
    /**
     * @var CertificateInterfaceFactory
     */
    protected CertificateInterfaceFactory $certificateFactory;
    /**
     * @var CertificateRepositoryInterface
     */
    protected CertificateRepositoryInterface $certificateRepository;

    /**
     * @param Context $context
     * @param CertificateInterfaceFactory $certificateFactory
     * @param CertificateRepositoryInterface $certificateRepository
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context                            $context,
        CertificateInterfaceFactory        $certificateFactory,
        CertificateRepositoryInterface     $certificateRepository,
        PageFactory                        $resultPageFactory
    ){
        $this->certificateRepository = $certificateRepository;
        $this->certificateFactory = $certificateFactory;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @return Redirect|ResultInterface|Page
     */
    public function execute()
    {
        $certificateId = (int)$this->getRequest()->getParam('certificate_id');

        $certificateTitle = "Certificate";
        if ($certificateId) {
            $certificateTitle = $this->certificateFactory->create()->getName();
            $certificate = $this->certificateRepository->getById($certificateId);
            if (!$certificate->getId()) {
                $this->messageManager->addErrorMessage(__('No certificate with that id'));
                return $this->resultRedirectFactory->create()->setPath('*/*/');
            }
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu("Elogic_Certificate::certificate");
        $resultPage->getConfig()->getTitle()->prepend(__($certificateTitle));
        $resultPage->addHandle('certificate' . $certificateId);
        return $resultPage;

    }
}
