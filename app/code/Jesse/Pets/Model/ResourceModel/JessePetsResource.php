<?php

namespace Jesse\Pets\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class JessePetsResource extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'jesse_pets_resource_model';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('jesse_pets', 'entity_id');
        $this->_useIsObjectNew = true;
    }
}
