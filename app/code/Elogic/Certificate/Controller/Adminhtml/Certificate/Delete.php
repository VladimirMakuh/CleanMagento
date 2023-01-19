<?php
declare(strict_types=1);

namespace Elogic\Certificate\Controller\Adminhtml\Certificate;

use Elogic\Certificate\Api\Data\CertificateInterfaceFactory;
use Elogic\Certificate\Api\CertificateRepositoryInterface;
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
     * @param RedirectFactory $resultRedirectFactory
     */
    public function __construct(
        Context                             $context,
        CertificateInterfaceFactory         $certificateFactory,
        CertificateRepositoryInterface      $certificateRepository,
        RedirectFactory                     $resultRedirectFactory
    ){
        $this->resultFactory = $resultRedirectFactory;
        $this->certificateRepository = $certificateRepository;
        $this->certificateFactory = $certificateFactory;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('certificate_id');

        $this->certificateRepository->deleteById((int)$id);
        $this->messageManager->addSuccessMessage(__('Certificate have been deleted.'));
        $result = $this->resultRedirectFactory->create();
        $result->setPath('elogic/certificate/index');

        return $result;
    }
}
