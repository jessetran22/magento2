<?php

namespace Jesse\Animal\Api;

use Jesse\Animal\Api\Data\AnimalInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Animal CRUD interface.
 * @api
 */
interface AnimalRepositoryInterface
{
    /**
     * Save Animal.
     *
     * @param AnimalInterface|DataObject $animal
     *
     * @return int
     * @throws CouldNotSaveException
     */
    public function save(AnimalInterface $animal): int;

    /**
     * Delete Animal by Id
     *
     * @param $entityId
     * @return void
     */
    public function deleteById($entityId);
}
