<?php

namespace Jesse\Pets\Mapper;

use Jesse\Pets\Api\Data\JessePetsInterface;
use Jesse\Pets\Api\Data\JessePetsInterfaceFactory;
use Jesse\Pets\Model\JessePetsModel;
use Magento\Framework\DataObject;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Converts a collection of JessePets entities to an array of data transfer objects.
 */
class JessePetsDataMapper
{
    /**
     * @var JessePetsInterfaceFactory
     */
    private $entityDtoFactory;

    /**
     * @param JessePetsInterfaceFactory $entityDtoFactory
     */
    public function __construct(
        JessePetsInterfaceFactory $entityDtoFactory
    ) {
        $this->entityDtoFactory = $entityDtoFactory;
    }

    /**
     * Map magento models to DTO array.
     *
     * @param AbstractCollection $collection
     *
     * @return array|JessePetsInterface[]
     */
    public function map(AbstractCollection $collection): array
    {
        $results = [];
        /** @var JessePetsModel $item */
        foreach ($collection->getItems() as $item) {
            /** @var JessePetsInterface|DataObject $entityDto */
            $entityDto = $this->entityDtoFactory->create();
            $entityDto->addData($item->getData());

            $results[] = $entityDto;
        }

        return $results;
    }
}
