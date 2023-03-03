<?php

namespace App\Entity;

use App\Repository\NewsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass:NewsRepository::class)]
class News
{

    #[ORM\Id()]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private $id;

    #[ORM\Column(type: 'string')]
    private ?string $title = null;

    #[ORM\Column(type: 'string')]
    private ?string $text = null;

    #[ORM\Column(type: 'string')]
    private ?string $slug = null;

    #[ORM\OneToOne(targetEntity: Image::class)]
    private ?Image $image = null;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    private ?Category $category = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $newsState = true;

    public function getId()
    {
		return $this->id;
	}
    public function getTitle(): ?string 
    {
		return $this->title;
	}
	public function setTitle(?string $title): self 
    {
		$this->title = $title;
		return $this;
	}
    public function getText(): ?string 
    {
		return $this->text;
	}
	public function setText(?string $text): self 
    {
		$this->text = $text;
		return $this;
	}
    public function getSlug(): ?string 
    {
		return $this->slug;
	}
	public function setSlug(?string $slug): self 
    {
		$this->slug = $slug;
		return $this;
	}
    public function getImage(): ?Image 
    {
		return $this->image;
	}
	public function setImage(?Image $image): self 
    {
		$this->image = $image;
		return $this;
	}
    public function getCategory(): ?Category
    {
		return $this->category;
	}
	public function setCategory(Category $category): self 
    {
		$this->category = $category;
		return $this;
	}
 
    public function getNewsState(): ?bool
    {
        return $this->newsState;
    }

    public function setNewsState(?bool $newsState): self
    {
        $this->newsState = $newsState;
        return $this;
    }
}