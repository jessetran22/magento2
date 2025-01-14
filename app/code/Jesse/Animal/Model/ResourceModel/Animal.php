<?php

namespace Jesse\Animal\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Animal extends AbstractDb
{

    /**
     * @inheritdoc
     */
    protected $_useIsObjectNew = true;

    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('jesse_animal', 'entity_id');
    }
}
