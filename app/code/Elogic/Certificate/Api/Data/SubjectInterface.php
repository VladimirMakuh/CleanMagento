<?php

namespace Elogic\Certificate\Api\Data;

interface SubjectInterface
{
    /**
     * String constants for property names
     */
    public const SUBJECT_ID      = "subject_id";
    public const SUBJECT         = "subject";

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
     * Getter for Subject.
     *
     * @return string|null
     */
    public function getSubject(): ?string;

    /**
     * Setter for Name.
     *
     * @param string|null $subject
     * @return void
     */
    public function setSubject(?string $subject): void;
}
