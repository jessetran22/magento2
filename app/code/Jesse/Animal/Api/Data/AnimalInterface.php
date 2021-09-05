<?php

namespace Jesse\Animal\Api\Data;

interface AnimalInterface
{
    /**
     * String constants for property names
     */
    const ENTITY_ID = "entity_id";
    const INCREMENT_ID = "increment_id";
    const SPECIES = "species";
    const NAME = "name";
    const AGE = "age";
    const BIRTHDAY = "birthday";
    const WEIGHT = "weight";
    const DESCRIPTION = "description";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    /**
     * Getter for IncrementId.
     *
     * @return int|null
     */
    public function getIncrementId(): ?int;

    /**
     * Setter for IncrementId.
     *
     * @param int|null $incrementId
     *
     * @return void
     */
    public function setIncrementId(?int $incrementId): void;

    /**
     * Getter for Species.
     *
     * @return string|null
     */
    public function getSpecies(): ?string;

    /**
     * Setter for Species.
     *
     * @param string|null $species
     *
     * @return void
     */
    public function setSpecies(?string $species): void;

    /**
     * Getter for Name.
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Setter for Name.
     *
     * @param string|null $name
     *
     * @return void
     */
    public function setName(?string $name): void;

    /**
     * Getter for Age.
     *
     * @return int|null
     */
    public function getAge(): ?int;

    /**
     * Setter for Age.
     *
     * @param int|null $age
     *
     * @return void
     */
    public function setAge(?int $age): void;

    /**
     * Getter for Birthday.
     *
     * @return string|null
     */
    public function getBirthday(): ?string;

    /**
     * Setter for Birthday.
     *
     * @param string|null $birthday
     *
     * @return void
     */
    public function setBirthday(?string $birthday): void;

    /**
     * Getter for Weight.
     *
     * @return float|null
     */
    public function getWeight(): ?float;

    /**
     * Setter for Weight.
     *
     * @param float|null $weight
     *
     * @return void
     */
    public function setWeight(?float $weight): void;

    /**
     * Getter for Description.
     *
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * Setter for Description.
     *
     * @param string|null $description
     *
     * @return void
     */
    public function setDescription(?string $description): void;

    /**
     * Getter for CreatedAt.
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * Setter for CreatedAt.
     *
     * @param string|null $createdAt
     *
     * @return void
     */
    public function setCreatedAt(?string $createdAt): void;

    /**
     * Getter for UpdatedAt.
     *
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * Setter for UpdatedAt.
     *
     * @param string|null $updatedAt
     *
     * @return void
     */
    public function setUpdatedAt(?string $updatedAt): void;
}
