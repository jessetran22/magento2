<?php

namespace Jesse\Animal\Model;

use Jesse\Animal\Api\AnimalRepositoryInterface;
use Jesse\Animal\Api\Data\AnimalInterface;
use Jesse\Animal\Api\Data\AnimalInterfaceFactory;
use Jesse\Animal\Command\Animal\SaveCommand;
use Jesse\Animal\Command\Animal\DeleteByIdCommand;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Webapi\Rest\Request;

class AnimalRepository implements AnimalRepositoryInterface
{
    /**
     * @var Request
     */
    protected Request $request;
    /**
     * @var SaveCommand
     */
    private SaveCommand $saveCommand;
    /**
     * @var DeleteByIdCommand
     */
    private DeleteByIdCommand $deleteByIdCommand;
    /**
     * @var AnimalInterfaceFactory
     */
    private AnimalInterfaceFactory $animalInterfaceFactory;

    public function __construct(
        SaveCommand            $saveCommand,
        DeleteByIdCommand      $deleteByIdCommand,
        Request                $request,
        AnimalInterfaceFactory $animalInterfaceFactory
    ) {
        $this->saveCommand = $saveCommand;
        $this->deleteByIdCommand = $deleteByIdCommand;
        $this->request = $request;
        $this->animalInterfaceFactory = $animalInterfaceFactory;
    }

    /**
     * @inheritdoc
     */
    public function save(AnimalInterface $animal): int
    {
        $dataBody = $this->request->getBodyParams();
        $animalModel = $this->animalInterfaceFactory->create();
        $animalModel->setData($dataBody['animal']);
        return $this->saveCommand->execute($animalModel);
    }

    /**
     * @inheritDoc
     */
    public function deleteById($entityId)
    {
        try {
            $this->deleteByIdCommand->execute($entityId);
        } catch (CouldNotDeleteException $e) {
        } catch (NoSuchEntityException $e) {
        }
    }
}
