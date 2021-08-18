<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Jesse\Pets\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * @api
 * @since 100.0.2
 */
interface JessePetsSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get attributes list.
     *
     * @return JessePetsInterface[]
     */
    public function getItems();

    /**
     * Set attributes list.
     *
     * @param JessePetsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
