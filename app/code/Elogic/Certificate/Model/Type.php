<?php

namespace Elogic\Certificate\Model;

use Elogic\Certificate\Api\Data\TypeInterface;
use Elogic\Certificate\Model\ResourceModel\TypeResource as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class Type extends AbstractModel implements TypeInterface
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * Getter for TypeId.
     * @return int|null
     */
    public function getTypeId(): ?int
    {
        return $this->getData(self::TYPE_ID) === null ? null
            : (int)$this->getData(self::TYPE_ID);
    }

    /**
     * Setter for TypeId.
     * @param int|null $typeId
     * @return void
     */
    public function setTypeId(?int $typeId): void
    {
        $this->setData(self::TYPE_ID, $typeId);
    }

    /**
     * Getter for Type.
     * @return string|null
     */
    public function getType(): ?string
    {
       return $this->getData(self::TYPE);
    }

    /**
     * Setter for Type.
     * @param string|null $type
     * @return void
     */
    public function setType(?string $type): void
    {
        $this->setData(self::TYPE, $type);
    }
}
