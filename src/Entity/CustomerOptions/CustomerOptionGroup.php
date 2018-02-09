<?php
declare(strict_types=1);

namespace Brille24\CustomerOptionsBundle\Entity\CustomerOptions;

use Brille24\CustomerOptionsBundle\Entity\ProductInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Resource\Model\TranslatableTrait;

class CustomerOptionGroup implements CustomerOptionGroupInterface
{
    use TranslatableTrait {
        __construct as protected initializeTranslationsCollection;
    }

    /** @var int */
    private $id;

    /** @var string */
    private $code;

    /** @var ArrayCollection */
    private $customerOptionAssociations;

    /** @var ArrayCollection */
    private $products;

    public function __construct()
    {
        $this->customerOptionAssociations = new ArrayCollection();
        $this->products        = new ArrayCollection();
        $this->initializeTranslationsCollection();
    }

    /**
     * @return CustomerOptionGroupTranslationInterface
     */
    public function createTranslation(): CustomerOptionGroupTranslationInterface
    {
        return new CustomerOptionGroupTranslation();
    }

    /** {@inheritdoc} */
    public function getId(): ?int
    {
        return $this->id;
    }

    /** {@inheritdoc} */
    public function getName(): ?string
    {
        /** @var CustomerOptionGroupTranslationInterface $translation */
        $translation = $this->getTranslation();
        return $translation->getName();
    }

    /** {@inheritdoc} */
    public function setName(?string $name): void
    {
        /** @var CustomerOptionGroupTranslationInterface $translation */
        $translation = $this->getTranslation();
        $translation->setName($name);
    }

    /** {@inheritdoc} */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /** {@inheritdoc} */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    /** {@inheritdoc} */
    public function getCustomerOptionAssociations(): array
    {
        return $this->customerOptionAssociations->toArray();
    }

    /** {@inheritdoc} */
    public function setCustomerOptionAssociations(array $associations): void
    {
        $associations = array_filter(
            $associations,
            function ($value) { return $value instanceof CustomerOptionAssociationInterface; });

        $this->customerOptionAssociations = new ArrayCollection($associations);
    }

    /** {@inheritdoc} */
    public function getProducts(): array
    {
        return $this->products->toArray();
    }

    /**
     * @param array $customerOptions
     */
    public function setProducts(array $customerOptions): void
    {
        $customerOptions = array_filter(
            $customerOptions,
            function ($value) { return $value instanceof ProductInterface; });

        $this->products = new ArrayCollection($customerOptions);
    }

    public function __toString(): string
    {
        return (string)$this->getName();
    }
}