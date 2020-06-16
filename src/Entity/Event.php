<?php

namespace App\Entity;

use App\Repository\EventRepository;
use App\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @var \Category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="events")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
    */
    private $category;

    /**
     * @var ?Image
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Image", cascade="all", orphanRemoval=true)
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $image = null;

    /**
     * @var bool
     */
    private $deleteImage;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Category")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="events", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    /**
     * @return bool
     */
    public function getDeleteImage()
    {
        return $this->deleteImage;
    }

    public function setDeleteImage(bool $deleteImage)
    {
        $this->deleteImage = $deleteImage;
        if ($deleteImage) {
            $this->image = null;
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of image.
     *
     * @return ?Image
     */
    public function getImage()
    {
        return $this->image;
    }
    
    /**
     * Set the value of image.
     *
     * @param ?Image $image
     *
     * @return self
     */
    public function setImage(?Image $image)
    {
        if (empty($image->getFile())) {
            $image = null;
        }
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setEvents($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getEvents() === $this) {
                $comment->setEvents(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Get the value of categories
     *
     * @return  ArrayCollection
     */ 
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set the value of categories
     *
     * @param  ArrayCollection  $categories
     *
     * @return  self
     */ 
    public function setCategories(ArrayCollection $categories)
    {
        $this->categories = $categories;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    

    /**
     * Get the value of category
     *
     * @return  \Category
     */ 
    public function getCategory()
    {
        return $this->category;
    }

    /*
     * Set the value of category
     *
     * @param  \Category  $category
     *
     * @return  self
     */ 
    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }
}
