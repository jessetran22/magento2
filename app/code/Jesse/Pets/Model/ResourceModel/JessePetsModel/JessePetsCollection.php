<?php

namespace Jesse\Pets\Model\ResourceModel\JessePetsModel;

use Jesse\Pets\Model\JessePetsModel;
use Jesse\Pets\Model\ResourceModel\JessePetsResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class JessePetsCollection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'jesse_pets_collection';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(JessePetsModel::class, JessePetsResource::class);
    }
}
