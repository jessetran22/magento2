<?php

namespace Jesse\Animal\Command\Animal;

use Exception;
use Jesse\Animal\Model\AnimalFactory;
use Jesse\Animal\Model\ResourceModel\Animal as AnimalResource;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

/**
 * Delete Animal by id Command.
 */
class DeleteByIdCommand
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var AnimalFactory
     */
    private AnimalFactory $animalFactory;

    /**
     * @var AnimalResource
     */
    private AnimalResource $animalResource;

    /**
     * @param LoggerInterface $logger
     * @param AnimalFactory $animalFactory
     * @param AnimalResource $animalResource
     */
    public function __construct(
        LoggerInterface $logger,
        AnimalFactory   $animalFactory,
        AnimalResource  $animalResource
    ) {
        $this->logger = $logger;
        $this->animalFactory = $animalFactory;
        $this->animalResource = $animalResource;
    }

    /**
     * Delete Animal.
     *
     * @param int $entityId
     *
     * @return void
     * @throws CouldNotDeleteException|NoSuchEntityException
     */
    public function execute(int $entityId)
    {
        try {
            $model = $this->animalFactory->create();
            $this->animalResource->load($model, $entityId, 'entity_id');

            if (!$model->getData('entity_id')) {
                throw new NoSuchEntityException(
                    __('Could not find Animal with id: `%id`',
                        [
                            'id' => $entityId
                        ]
                    )
                );
            }

            $this->animalResource->delete($model);
        } catch (Exception $exception) {
            $this->logger->error(
                __('Could not delete Animal. Original message: {message}'),
                [
                    'message' => $exception->getMessage(),
                    'exception' => $exception
                ]
            );
            throw new CouldNotDeleteException(__('Could not delete Animal.'));
        }
    }
}
