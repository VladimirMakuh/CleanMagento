<?php
declare(strict_types=1);

namespace Elogic\Certificate\Api;

use Elogic\Certificate\Api\Data\CertificateInterface;

interface CertificateRepositoryInterface
{
    /**
     * @param CertificateInterface $certificate
     * @return CertificateInterface
     */
    public function save(CertificateInterface $certificate): CertificateInterface;

    /**
     * @param CertificateInterface $certificate
     * @return void
     */
    public function delete(CertificateInterface $certificate): void;

    /**
     * @param int $certificate_id
     * @return void
     */
    public function deleteById(int $certificate_id): void;

    /**
     * @param int $certificate_id
     * @return CertificateInterface
     */
    public function getById(int $certificate_id): CertificateInterface;
}
