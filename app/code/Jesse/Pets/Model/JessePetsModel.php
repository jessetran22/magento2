<?php

namespace Jesse\Pets\Model;

use Jesse\Pets\Model\ResourceModel\JessePetsResource;
use Magento\Framework\Model\AbstractModel;

class JessePetsModel extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'jesse_pets_model';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(JessePetsResource::class);
    }
}
