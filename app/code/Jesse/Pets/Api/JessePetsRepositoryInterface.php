<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Jesse\Pets\Api;

use Jesse\Pets\Api\Data\JessePetsSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * @api
 * @since 100.0.2
 */
interface JessePetsRepositoryInterface
{
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return Jesse\Pets\Api\Data\JessePetsSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
