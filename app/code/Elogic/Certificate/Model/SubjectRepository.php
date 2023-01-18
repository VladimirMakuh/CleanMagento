<?php
declare(strict_types=1);

namespace Elogic\Certificate\Model;

use Elogic\Certificate\Api\Data\SubjectInterface;
use Elogic\Certificate\Api\Data\SubjectInterfaceFactory;
use Elogic\Certificate\Api\SubjectRepositoryInterface;
use Elogic\Certificate\Model\ResourceModel\SubjectResource as Resource;
use Exception;
use Magento\Framework\Exception\AlreadyExistsException;

class SubjectRepository implements SubjectRepositoryInterface
{
    /**
     * @var SubjectInterfaceFactory
     */
    private SubjectInterfaceFactory $subjectFactory;
    /**
     * @var Resource
     */
    private Resource $subjectResource;

    /**
     * @param SubjectInterfaceFactory $subjectFactory
     * @param Resource $subjectResource
     */
    public function __construct(
        SubjectInterfaceFactory                  $subjectFactory,
        Resource                                 $subjectResource
    ){
        $this->subjectFactory = $subjectFactory;
        $this->subjectResource = $subjectResource;
    }

    /**
     * @param SubjectInterface $subject
     * @return SubjectInterface
     * @throws AlreadyExistsException
     */
    public function save(SubjectInterface $subject): SubjectInterface
    {
        $this->subjectResource->save($subject);
        return $subject;
    }

    /**
     * @param int $subject_id
     * @return void
     * @throws Exception
     */
    public function deleteById(int $subject_id): void
    {
        $subject = $this->getById($subject_id);
        $this->delete($subject);
    }

    /**
     * @param int $subject_id
     * @return string|SubjectInterface $subject
     */
    public function getById(int $subject_id): SubjectInterface
    {
        $subject = $this->subjectFactory->create();
        $this->subjectResource->load($subject, $subject_id);
        return $subject;
    }

    /**
     * @param SubjectInterface $subject
     * @return void
     * @throws Exception
     */
    public function delete(SubjectInterface $subject): void
    {
        $this->subjectResource->delete($subject);
    }
}
