<?php

namespace Jesse\Pets\Command\JessePets;

use Exception;
use Jesse\Pets\Api\Data\JessePetsInterface;
use Jesse\Pets\Model\JessePetsModel;
use Jesse\Pets\Model\JessePetsModelFactory;
use Jesse\Pets\Model\ResourceModel\JessePetsResource;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\CouldNotSaveException;
use Psr\Log\LoggerInterface;

/**
 * Save JessePets Command.
 */
class SaveCommand
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
     * Save JessePets.
     *
     * @param JessePetsInterface|DataObject $jessePets
     *
     * @return int
     * @throws CouldNotSaveException
     */
    public function execute(JessePetsInterface $jessePets): int
    {
        try {
            /** @var JessePetsModel $model */
            $model = $this->modelFactory->create();
            $model->addData($jessePets->getData());
            $model->setHasDataChanges(true);

            if (!$model->getId()) {
                $model->isObjectNew(true);
            }
            $this->resource->save($model);
        } catch (Exception $exception) {
            $this->logger->error(
                __('Could not save JessePets. Original message: {message}'),
                [
                    'message' => $exception->getMessage(),
                    'exception' => $exception
                ]
            );
            throw new CouldNotSaveException(__('Could not save JessePets.'));
        }

        return (int)$model->getEntityId();
    }
}
