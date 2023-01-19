<?php
declare(strict_types=1);

namespace Elogic\Certificate\Model;

use Elogic\Certificate\Api\Data\CertificateInterface;
use Elogic\Certificate\Model\ResourceModel\CertificateResource as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class Certificate extends AbstractModel implements CertificateInterface
{

    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @inheritDoc
     */
    public function getCertificateId(): ?int
    {
        return $this->getData(self::CERTIFICATE_ID) === null ? null
            : (int)$this->getData(self::CERTIFICATE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setCertificateId(?int $certificateId): void
    {
        $this->setData(self::CERTIFICATE_ID, $certificateId);
    }

    /**
     * @inheritDoc
     */
    public function getTypeId(): ?int
    {
        return $this->getData(self::TYPE_ID) === null ? null
            : (int)$this->getData(self::TYPE_ID);    }

    /**
     * @inheritDoc
     */
    public function setTypeId(?int $typeId): void
    {
        $this->setData(self::TYPE_ID, $typeId);
    }

    /**
     * @inheritDoc
     */
    public function getSubjectId(): ?int
    {
        return $this->getData(self::SUBJECT_ID) === null ? null
            : (int)$this->getData(self::SUBJECT_ID);
    }

    /**
     * @inheritDoc
     */
    public function setSubjectId(?int $subjectId): void
    {
        $this->setData(self::SUBJECT_ID, $subjectId);
    }

    /**
     * @inheritDoc
     */
    public function getStudentName(): ?string
    {
        return $this->getData(self::STUDENT_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setStudentName(?string $studentName): void
    {
        $this->setData(self::STUDENT_NAME,$studentName);
    }

    /**
     * @inheritDoc
     */
    public function getStudentSurName(): ?string
    {
        return $this->getData(self::STUDENT_SURNAME);
    }

    /**
     * @inheritDoc
     */
    public function setStudentSurName(?string $studentSurMame): void
    {
        $this->setData(self::STUDENT_SURNAME,$studentSurMame);
    }

    /**
     * @inheritDoc
     */
    public function getDateValid(): ?string
    {
        return $this->getData(self::DATE_VALID);
    }

    /**
     * @inheritDoc
     */
    public function setDateValid(?string $dateValid): void
    {
        $this->setData(self::DATE_VALID,$dateValid);
    }

    /**
     * @inheritDoc
     */
    public function getSignature(): ?string
    {
        return $this->getData(self::SIGNATURE);
    }

    /**
     * @inheritDoc
     */
    public function setSignature(?string $signature): void
    {
        $this->setData(self::SIGNATURE,$signature);
    }
}
