<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use JMS\Serializer\Annotation\Expose;


/**
 * @ORM\Entity(repositoryClass="App\Repository\CardRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Card
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * * @JMS\Groups({"default","tags"})
        * @Expose
     */
    private $id;

    /**
   * @JMS\Groups({"default"})
      * @Expose
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;
     /**
     * @ORM\Column(type="string", length=255)
      * @JMS\Groups({"default"})
         * @Expose
     */
    private $img;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag",mappedBy="cards",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
      * @JMS\Groups({"default"})
         * @Expose
     * @ORM\JoinTable(name="card_tags")
     */
    private $tags;
       /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category",inversedBy="cards",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
   
     */
    private $category;
     /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SubCategory", mappedBy="cards",cascade={"persist"})
   * @JMS\Groups({"default"})
      * @Expose
    * @ORM\JoinTable(name="card_subcategory")
     */
    private $subcategories ;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=400, nullable=true)
     */
    private $notes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebook;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twitter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $instagram;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $send;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $relance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;
    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->subcategories = new ArrayCollection();
    }
     /**
     * @return Collection|SubCategory[]
     */
    public function getSubCategories()
    {
        return $this->subcategories;
    }
    public function setSubCategories(SubCategory $subcategory=null)
    {
        if($subcategory!=null){
            $subcategory->addCard($this);
        }
         // synchronously updating inverse side
        $this->subcategories[] = $subcategory;
    }
   /**
     * @param SubCategory $subcategory
     */
    public function removeSubCategory(SubCategory $subcategory)
    {
        if (!$this->subcategories->contains($subcategory)) {
            return;
        }    
        $this->subcategories->removeElement($subcategory);
        $subcategory->removeCard($this);
    }


 
    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;
    }
  

    /**
     * @return Collection|Tag[]
     */
    public function getTags()
    {
        return $this->tags;
    }
    public function setTags(Tag $tag)
    {
        $tag->addCard($this); // synchronously updating inverse side
        $this->tags[] = $tag;
    }

    public function getImg(){
        return $this->img;
    }
    public function setImg($img){
        return $this->img=$img;
    }



    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
      return  $this->name = $name;

     
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
      return  $this->url = $url;

      
    }

    public function getAdress()
    {
        return $this->adress;
    }

    public function setAdress( $adress)
    {
      return   $this->adress = $adress;

        
    }

    public function getNotes()
    {
        return $this->notes;
    }

    public function setNotes($notes=null)
    {
       return $this->notes = $notes;

     
    }

    public function getFacebook()
    {
        return $this->facebook;
    }

    public function setFacebook($facebook)
    {
     return   $this->facebook = $facebook;

       
    }

    public function getTwitter()
    {
        return $this->twitter;
    }

    public function setTwitter($twitter)
    {
       return $this->twitter = $twitter;

        
    }

    public function getInstagram(){
        return $this->instagram;
    }
    

    public function setInstagram( $instagram)
    {
       return  $this->instagram = $instagram;

       
    }

    public function getSend()
    {
        return $this->send;
    }

    public function setSend( $send)
    {
       return $this->send = $send;

     
    }

    public function getRelance()
    {
        return $this->relance;
    }

    public function setRelance( $relance)
    {
     return   $this->relance = $relance;

       
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus( $status)
    {
       return $this->status = $status;

        
    }
}
