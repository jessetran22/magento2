<?php

namespace Jesse\Pets\Ui\Component\Form;

use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;

/**
 * DataProvider component.
 */
class JessePets extends DataProvider
{
    /**
     * @inheritDoc
     */
    public function getData()
    {
        //TODO: implement data retrieving here based on search criteria
        return [
            []
        ];
    }
}
