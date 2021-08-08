<?php

namespace Jesse\Pets\Command\JessePets;

use Exception;
use Jesse\Pets\Model\JessePetsModel;
use Jesse\Pets\Model\JessePetsModelFactory;
use Jesse\Pets\Model\ResourceModel\JessePetsResource;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

/**
 * Delete JessePets by id Command.
 */
class DeleteByIdCommand
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var JessePetsModelFactory
     */
    private $modelFactory;

    /**
     * @var JessePetsResource
     */
    private $resource;

    /**
     * @param LoggerInterface $logger
     * @param JessePetsModelFactory $modelFactory
     * @param JessePetsResource $resource
     */
    public function __construct(
        LoggerInterface       $logger,
        JessePetsModelFactory $modelFactory,
        JessePetsResource     $resource
    ) {
        $this->logger = $logger;
        $this->modelFactory = $modelFactory;
        $this->resource = $resource;
    }

    /**
     * Delete JessePets.
     *
     * @param int $entityId
     *
     * @return void
     * @throws CouldNotDeleteException|NoSuchEntityException
     */
    public function execute(int $entityId)
    {
        try {
            /** @var JessePetsModel $model */
            $model = $this->modelFactory->create();
            $this->resource->load($model, $entityId, 'entity_id');

            if (!$model->getData('entity_id')) {
                throw new NoSuchEntityException(
                    __('Could not find JessePets with id: `%id`',
                        [
                            'id' => $entityId
                        ]
                    )
                );
            }

            $this->resource->delete($model);
        } catch (Exception $exception) {
            $this->logger->error(
                __('Could not delete JessePets. Original message: {message}'),
                [
                    'message' => $exception->getMessage(),
                    'exception' => $exception
                ]
            );
            throw new CouldNotDeleteException(__('Could not delete JessePets.'));
        }
    }
}
