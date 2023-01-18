<?php
declare(strict_types=1);

namespace Elogic\Certificate\Model;

use Elogic\Certificate\Api\Data\TypeInterface;
use Elogic\Certificate\Api\Data\TypeInterfaceFactory;
use Elogic\Certificate\Api\TypeRepositoryInterface;
use Elogic\Certificate\Model\ResourceModel\TypeResource as Resource;
use Exception;
use Magento\Framework\Exception\AlreadyExistsException;

class TypeRepository implements TypeRepositoryInterface
{
    /**
     * @var TypeInterfaceFactory
     */
    private TypeInterfaceFactory $typeFactory;
    /**
     * @var Resource
     */
    private Resource $typeResource;

    /**
     * @param TypeInterfaceFactory $typeFactory
     * @param Resource $typeResource
     */
    public function __construct(
        TypeInterfaceFactory                     $typeFactory,
        Resource                                 $typeResource
    ){
        $this->typeFactory = $typeFactory;
        $this->typeResource = $typeResource;
    }

    /**
     * @param TypeInterface $type
     * @return TypeInterface
     * @throws AlreadyExistsException
     */
    public function save(TypeInterface $type): TypeInterface
    {
        $this->typeResource->save($type);
        return $type;
    }

    /**
     * @param int $type_id
     * @return void
     * @throws Exception
     */
    public function deleteById(int $type_id): void
    {
        $type = $this->getById($type_id);
        $this->delete($type);
    }

    /**
     * @param int $type_id
     * @return string|TypeInterface $type
     */
    public function getById(int $type_id): TypeInterface
    {
        $type = $this->typeFactory->create();
        $this->typeResource->load($type, $type_id);
        return $type;
    }

    /**
     * @param TypeInterface $type
     * @return void
     * @throws Exception
     */
    public function delete(TypeInterface $type): void
    {
        $this->typeResource->delete($type);
    }
}
