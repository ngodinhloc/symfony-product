<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Product
 * @package App\Entity
 * @ORM\Table(name="product")
 * @ORM\Entity()
 */
class Product
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string")
     * @Assert\NotBlank
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(name="price", type="float")
     * @Assert\NotBlank
     * @var float
     */
    protected $price;

    /**
     * @ORM\Column(name="description", type="string")
     * @Assert\NotBlank
     * @var string
     */
    protected $description;

    /**
     * @ORM\Column(name="picture", type="string")
     * @Assert\NotBlank(message="Please, upload the product picture (JPG, PNG, JPEG, GIF).")
     * @Assert\File(mimeTypes={"image/png", "image/jpg", "image/jpeg", "image/gif"})
     * @var string
     */
    protected $picture;

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Product
     */
    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Product
     */
    public function setPrice(float $price): Product
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Product
     */
    public function setDescription(string $description): Product
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     * @return Product
     */
    public function setPicture(string $picture): Product
    {
        $this->picture = $picture;
        return $this;
    }
}