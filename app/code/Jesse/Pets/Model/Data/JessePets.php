<?php

namespace Jesse\Pets\Model\Data;

use Jesse\Pets\Api\Data\JessePetsInterface;
use Magento\Framework\DataObject;

class JessePets extends DataObject implements JessePetsInterface
{
    /**
     * @inheritDoc
     */
    public function getEntityId(): ?int
    {
        return $this->getData(self::ENTITY_ID) === null ? null
            : (int)$this->getData(self::ENTITY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setEntityId(?int $entityId): void
    {
        $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * @inheritDoc
     */
    public function getPetsId(): ?int
    {
        return $this->getData(self::PETS_ID) === null ? null
            : (int)$this->getData(self::PETS_ID);
    }

    /**
     * @inheritDoc
     */
    public function setPetsId(?int $petsId): void
    {
        $this->setData(self::PETS_ID, $petsId);
    }

    /**
     * @inheritDoc
     */
    public function getSpecies(): ?string
    {
        return $this->getData(self::SPECIES);
    }

    /**
     * @inheritDoc
     */
    public function setSpecies(?string $species): void
    {
        $this->setData(self::SPECIES, $species);
    }

    /**
     * @inheritDoc
     */
    public function getName(): ?string
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName(?string $name): void
    {
        $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getAge(): ?int
    {
        return $this->getData(self::AGE) === null ? null
            : (int)$this->getData(self::AGE);
    }

    /**
     * @inheritDoc
     */
    public function setAge(?int $age): void
    {
        $this->setData(self::AGE, $age);
    }

    /**
     * @inheritDoc
     */
    public function getBirthday(): ?string
    {
        return $this->getData(self::BIRTHDAY);
    }

    /**
     * @inheritDoc
     */
    public function setBirthday(?string $birthday): void
    {
        $this->setData(self::BIRTHDAY, $birthday);
    }

    /**
     * @inheritDoc
     */
    public function getWeight(): ?float
    {
        return $this->getData(self::WEIGHT) === null ? null
            : (float)$this->getData(self::WEIGHT);
    }

    /**
     * @inheritDoc
     */
    public function setWeight(?float $weight): void
    {
        $this->setData(self::WEIGHT, $weight);
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): ?string
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setDescription(?string $description): void
    {
        $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAt(): ?string
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
