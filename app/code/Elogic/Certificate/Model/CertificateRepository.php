<?php
declare(strict_types=1);

namespace Elogic\Certificate\Model;

use Elogic\Certificate\Api\Data\CertificateInterface;
use Elogic\Certificate\Api\Data\CertificateInterfaceFactory;
use Elogic\Certificate\Api\CertificateRepositoryInterface;
use Elogic\Certificate\Model\ResourceModel\CertificateResource as Resource;
use Exception;
use Magento\Framework\Exception\AlreadyExistsException;

class CertificateRepository implements CertificateRepositoryInterface
{
    /**
     * @var CertificateInterfaceFactory
     */
    private CertificateInterfaceFactory $certificateFactory;
    /**
     * @var Resource
     */
    private Resource $certificateResource;

    /**
     * @param CertificateInterfaceFactory $certificateFactory
     * @param Resource $certificateResource
     */
    public function __construct(
        CertificateInterfaceFactory              $certificateFactory,
        Resource                                 $certificateResource
    ){
        $this->certificateFactory = $certificateFactory;
        $this->certificateResource = $certificateResource;
    }

    /**
     * @param CertificateInterface $certificate
     * @return CertificateInterface
     * @throws AlreadyExistsException
     */
    public function save(CertificateInterface $certificate): CertificateInterface
    {
        $this->certificateResource->save($certificate);
        return $certificate;
    }

    /**
     * @param int $certificate_id
     * @return void
     * @throws Exception
     */
    public function deleteById(int $certificate_id): void
    {
        $certificate = $this->getById($certificate_id);
        $this->delete($certificate);
    }

    /**
     * @param int $certificate_id
     * @return string|CertificateInterface $certificate
     */
    public function getById(int $certificate_id): CertificateInterface
    {
        $certificate = $this->certificateFactory->create();
        $this->certificateResource->load($certificate, $certificate_id);
        return $certificate;
    }

    /**
     * @param CertificateInterface $certificate
     * @return void
     * @throws Exception
     */
    public function delete(CertificateInterface $certificate): void
    {
        $this->certificateResource->delete($certificate);
    }
}
