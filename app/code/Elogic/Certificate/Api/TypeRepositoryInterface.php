<?php
declare(strict_types=1);

namespace Elogic\Certificate\Api;

use Elogic\Certificate\Api\Data\TypeInterface;

interface TypeRepositoryInterface
{
    /**
     * @param TypeInterface $type
     * @return TypeInterface
     */
    public function save(TypeInterface $type): TypeInterface;

    /**
     * @param TypeInterface $type
     * @return void
     */
    public function delete(TypeInterface $type): void;

    /**
     * @param int $type_id
     * @return void
     */
    public function deleteById(int $type_id): void;

    /**
     * @param int $type_id
     * @return TypeInterface
     */
    public function getById(int $type_id): TypeInterface;
}
