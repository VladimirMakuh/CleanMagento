<?php
declare(strict_types=1);

namespace Elogic\Certificate\Api;

use Elogic\Certificate\Api\Data\SubjectInterface;

interface SubjectRepositoryInterface
{
    /**
     * @param SubjectInterface $subject
     * @return SubjectInterface
     */
    public function save(SubjectInterface $subject): SubjectInterface;

    /**
     * @param SubjectInterface $subject
     * @return void
     */
    public function delete(SubjectInterface $subject): void;

    /**
     * @param int $subject_id
     * @return void
     */
    public function deleteById(int $subject_id): void;

    /**
     * @param int $subject_id
     * @return SubjectInterface
     */
    public function getById(int $subject_id): SubjectInterface;
}
