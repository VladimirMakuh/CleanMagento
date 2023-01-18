<?php

namespace Elogic\Certificate\Api\Data;

interface TypeInterface
{
    /**
     * String constants for property names
     */
    public const TYPE_ID      = "type_id";
    public const TYPE         = "type";

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
     *
     * @return void
     */
    public function setTypeId(?int $typeId): void;

    /**
     * Getter for Type.
     *
     * @return string|null
     */
    public function getType(): ?string;

    /**
     * Setter for Type.
     *
     * @param string|null $type
     * @return void
     */
    public function setType(?string $type): void;
}
