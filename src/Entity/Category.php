<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @Groups({ "category_list"})
     * @ORM\Column(type="integer")
      * @Groups({"category_items", "category_list"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
    * @Groups({"category_items", "category_list"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $color;
     /**
     * @ORM\OneToMany(targetEntity="App\Entity\Card", mappedBy="category")
    * @Groups({"category_items", "group2"})
    *@Serializer\Expose()
     */
    private $cards;
      /**
     * @ORM\OneToMany(targetEntity="App\Entity\SubCategory", mappedBy="category")
     @Groups({ "category_items","group2"})
     */
    private $subcategories;


    public function __construct()
    {
        $this->cards = new ArrayCollection();
        $this->subcategories = new ArrayCollection();
    }

    /**
     * @return Collection|Card[]
     */
    public function getCards()
    {
        return $this->cards;
    }
     /**
     * @return Collection|SubCategory[]
     */
    public function getSubcategories()
    {
        return $this->subcategories;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }
}
