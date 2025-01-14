<?php

namespace Jesse\Pets\Block\Form\JessePets;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Back to list button.
 */
class Back extends GenericButton implements ButtonProviderInterface
{
    /**
     * Retrieve Back To Grid button settings.
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return $this->wrapButtonSettings(
            'Back To Grid',
            'back',
            sprintf("location.href = '%s';", $this->getUrl('*/*/')),
            [],
            30
        );
    }
}
