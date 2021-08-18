<?php

namespace Jesse\Pets\Model;

use Jesse\Pets\Api\Data\JessePetsSearchResultsInterfaceFactory;
use Jesse\Pets\Api\JessePetsRepositoryInterface;
use Jesse\Pets\Model\ResourceModel\JessePetsModel\JessePetsCollectionFactory;
use Jesse\Pets\Query\JessePets\GetListQuery;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\Search\SearchCriteria;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Ui\DataProvider\SearchResultFactory;

class JessePetsRepository implements JessePetsRepositoryInterface
{
    /**
     * @var GetListQuery
     */
    private GetListQuery $getListQuery;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var JessePetsCollectionFactory
     */
    private $jessePetsCollectionFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;
    /**
     * @var JessePetsSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;
    private $searchResultFactory;
    /**
     * @var SearchCriteria
     */
    protected $searchCriteria;


    public function __construct(
        CollectionProcessorInterface  $collectionProcessor,
        JessePetsCollectionFactory    $jessePetsCollectionFactory,
        GetListQuery                           $getListQuery,
        SearchCriteriaBuilder                  $searchCriteriaBuilder,
        SearchResultFactory                    $searchResultFactory,
        JessePetsSearchResultsInterfaceFactory $searchResultsFactory

    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->jessePetsCollectionFactory = $jessePetsCollectionFactory;
        $this->getListQuery = $getListQuery;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchResultFactory = $searchResultFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->jessePetsCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var Data\JessePetsSearchResultsInterface $searchResults */
        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);

        return $searchResult;
    }



}
