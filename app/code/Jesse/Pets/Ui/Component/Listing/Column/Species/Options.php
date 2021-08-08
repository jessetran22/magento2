<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Jesse\Pets\Ui\Component\Listing\Column\Species;

use Jesse\Pets\Model\ResourceModel\JessePetsModel\JessePetsCollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;


/**
 * Class Options for Listing Column Status
 */
class Options implements OptionSourceInterface
{

    /**
     * @var JessePetsCollectionFactory
     */
    private JessePetsCollectionFactory $entityCollectionFactory;


    /**
     * @param JessePetsCollectionFactory $entityCollectionFactory
     */
    public function __construct(
        JessePetsCollectionFactory $entityCollectionFactory
    ) {
        $this->entityCollectionFactory = $entityCollectionFactory;
    }


    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $collection = $this->entityCollectionFactory->create();
        $select = $collection->getSelect();
        $select->reset();
        $select->distinct(true);
        $select->from($collection->getMainTable(), ['species']);
        $select->where('species IS NOT NULL');

        $options[] = [
            ['value' => '', 'label' => __('--Please Select--')]
        ];

        foreach ($collection->getItems() as $item) {
            if (trim($item->getSpecies()) !== "") {
                $options[] = [
                    'value' => $item->getSpecies(),
                    'label' => $item->getSpecies()
                ];
            }
        }

        return $options;
    }
}
