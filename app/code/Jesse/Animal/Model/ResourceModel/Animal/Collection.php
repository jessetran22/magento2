<?php
namespace Jesse\Animal\Model\ResourceModel\Animal;

use Jesse\Animal\Model\Animal as Model;
use Jesse\Animal\Model\ResourceModel\Animal as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';
	protected $_eventPrefix = 'jesse_animal_animal_collection';
	protected $_eventObject = 'animal_collection';

    /**
     * Define model & resource model
     */
    protected function _construct(): void
    {
        $this->_init(
            Model::class,
            ResourceModel::class
        );
    }
}
