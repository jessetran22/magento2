<?php

namespace Jesse\Animal\Command\Animal;

use Exception;
use Jesse\Animal\Api\Data\AnimalInterface;
use Jesse\Animal\Model\Animal;
use Jesse\Animal\Model\AnimalFactory;
use Jesse\Animal\Model\ResourceModel\Animal as AnimalResource;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\CouldNotSaveException;
use Psr\Log\LoggerInterface;

/**
 * Save Animal Command.
 */
class SaveCommand
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var AnimalFactory
     */
    private $animalModelFactory;

    /**
     * @var AnimalResource
     */
    private $animalResource;

    /**
     * @param LoggerInterface $logger
     * @param AnimalFactory $animalModelFactory
     * @param AnimalResource $animalResource
     */
    public function __construct(
        LoggerInterface $logger,
        AnimalFactory   $animalModelFactory,
        AnimalResource  $animalResource
    ) {
        $this->logger = $logger;
        $this->animalModelFactory = $animalModelFactory;
        $this->animalResource = $animalResource;
    }

    /**
     * Save Animal.
     *
     * @param AnimalInterface|DataObject $animal
     *
     * @return int
     * @throws CouldNotSaveException
     */
    public function execute(AnimalInterface $animal): int
    {
        try {
            /** @var Animal $animalModel */
            $animalModel = $this->animalModelFactory->create();
            $animalModel->addData($animal->getData());
            $animalModel->setHasDataChanges(true);

            if (!$animalModel->getId()) {
                $animalModel->isObjectNew(true);
            }
            $this->animalResource->save($animalModel);
        } catch (Exception $exception) {
            $this->logger->error(
                __('Could not save Animal. Original message: {message}'),
                [
                    'message' => $exception->getMessage(),
                    'exception' => $exception
                ]
            );
            throw new CouldNotSaveException(__('Could not save Animal.'));
        }

        return (int)$animalModel->getEntityId();
    }
}
