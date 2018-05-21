<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubCategoryRepository")
  * @JMS\ExclusionPolicy("all")

 */
class SubCategory
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
      * @JMS\Groups({"default"})
        * @Expose
     * @ORM\Column(type="string", length=255)
     
     */
    private $name;
     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="cards")
     * @ORM\JoinColumn(nullable=true)

     */
    private $category;
     /**
     
     * @ORM\ManyToMany(targetEntity="App\Entity\Card",inversedBy="subcategories")
     */
    private $cards;
    
    public function __construct()
     {
        $this->cards = new ArrayCollection();
     
    }

    /**
     * @return Collection|Card[]
     */
    public function getCards()
    {
        return $this->cards;
    }
     public function addCard(Card $card)
    {
        $this->cards[] = $card;
    }
     /**
     * @param Card $card
     */
    public function removeCard(Card $card)
    {
        if (!$this->cards->contains($card)) {
            return;
        }    
        $this->cards->removeElement($card);
        $card->removeSubCategory($this);
    }
     
   
    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;
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

   
}
