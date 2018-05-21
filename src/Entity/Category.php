<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use JMS\Serializer\Annotation\Expose;
/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @JMS\ExclusionPolicy("all")

 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @JMS\Groups({"default"})
        * @Expose
     * @ORM\Column(type="integer")
   
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
      * @Expose
     * @JMS\Groups({"default"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $color;
     /**
     * @ORM\OneToMany(targetEntity="App\Entity\Card", mappedBy="category")
    * @JMS\Groups({"default"})
 * @Expose
     */
    private $cards;
      /**
     * @ORM\OneToMany(targetEntity="App\Entity\SubCategory", mappedBy="category")
 * @JMS\Groups({"default"})
 * @Expose
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
