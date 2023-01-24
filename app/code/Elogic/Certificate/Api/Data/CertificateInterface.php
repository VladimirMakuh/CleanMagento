<?php

namespace Elogic\Certificate\Api\Data;

interface CertificateInterface
{
    /**
     * String constants for property names
     */
    public const CERTIFICATE_ID      = "certificate_id";
    public const TYPE_ID             = "type_id";
    public const SUBJECT_ID          = "subject_id";
    public const CERT_NUMBER         = "cert_number";
    public const STUDENT_NAME        = "student_name";
    public const STUDENT_SURNAME     = "student_surname";
    public const DATE_VALID          = "date_valid";
    public const SIGNATURE           = "signature";

    /**
     * Getter for CertificateId.
     *
     * @return int|null
     */
    public function getCertificateId(): ?int;

    /**
     * Setter for CertificateId.
     *
     * @param int|null $certificateId
     * @return void
     */
    public function setCertificateId(?int $certificateId): void;

    /**
     * Getter for TypeId.
     *
     * @return int|null
     */
    public function getTypeId(): ?int;

    /**
     * Setter for TypeId.
     *
     * @param int|null $typeId
     * @return void
     */
    public function setTypeId(?int $typeId): void;


    /**
     * Getter for SubjectId.
     *
     * @return int|null
     */
    public function getSubjectId(): ?int;

    /**
     * Setter for SubjectId.
     *
     * @param int|null $subjectId
     *
     * @return void
     */
    public function setSubjectId(?int $subjectId): void;

    /**
     * Getter for CertNumber.
     *
     * @return string|null
     */
    public function getCertNumber(): ?string;

    /**
     * Setter for CertNumber.
     *
     * @param string|null $cert_number
     * @return void
     */
    public function setCertNumber(?string $cert_number): void;

    /**
     * Getter for StudentName.
     *
     * @return string|null
     */
    public function getStudentName(): ?string;
    /**
     * Setter for StudentName.
     *
     * @param string|null $studentName
     * @return void
     */
    public function setStudentName(?string $studentName): void;

    /**
     * Getter for StudentSurname.
     *
     * @return string|null
     */
    public function getStudentSurname(): ?string;

    /**
     * Setter for StudentSurname.
     *
     * @param string|null $studentSurname
     * @return void
     */
    public function setStudentSurname(?string $studentSurname): void;

    /**
     * Getter for DateValid.
     *
     * @return string|null
     */
    public function getDateValid(): ?string;

    /**
     * Setter for DateValid.
     *
     * @param string|null $dateValid
     * @return void
     */
    public function setDateValid(?string $dateValid): void;

    /**
     * Getter for Signature.
     *
     * @return string|null
     */
    public function getSignature(): ?string;

    /**
     * Setter for Signature.
     *
     * @param string|null $signature
     * @return void
     */
    public function setSignature(?string $signature): void;
}
