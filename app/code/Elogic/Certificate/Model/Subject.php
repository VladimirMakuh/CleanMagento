<?php

namespace Elogic\Certificate\Model;

use Elogic\Certificate\Api\Data\SubjectInterface;
use Elogic\Certificate\Model\ResourceModel\SubjectResource as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class Subject extends AbstractModel implements SubjectInterface
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
    /**
     * Getter for SubjectId.
     *
     * @return int|null
     */
    public function getSubjectId(): ?int
    {
        return $this->getData(self::SUBJECT_ID) === null ? null
            : (int)$this->getData(self::SUBJECT_ID);
    }

    /**
     * Setter for SubjectId.
     *
     * @param int|null $subjectId
     *
     * @return void
     */
    public function setSubjectId(?int $subjectId): void
    {
        $this->setData(self::SUBJECT_ID, $subjectId);
    }

    /**
     * Getter for Subject.
     *
     * @return string|null
     */
    public function getSubject(): ?string
    {
        return $this->getData(self::SUBJECT);
    }

    /**
     * Setter for Subject.
     *
     * @param string|null $subject
     * @return void
     */
    public function setSubject(?string $subject): void
    {
        $this->setData(self::SUBJECT, $subject);
    }
}
