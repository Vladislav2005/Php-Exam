<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass:CategoryRepository::class)]
class Category
{

    #[ORM\Id()]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private $id;

    #[ORM\Column(type: 'string')]
    private ?string $title = null;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'categoryes')]
    private ?Category $category = null;

    #[ORM\OneToMany(targetEntity: Category::class, mappedBy: 'category')]
    private Collection $categoryes;

    #[ORM\Column(type: 'string')]
    private ?string $slug = null;

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
    public function getCategory(): ?Category
    {
		return $this->category;
	}
	public function setCategory(Category $category): self 
    {
		$this->category = $category;
		return $this;
	}
    public function getCategoryes(): Collection 
    {
		return $this->categoryes;
	}
	public function setCategoryes(Collection $categoryes): self 
    {
		$this->categoryes = $categoryes;
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

  public function __toString()
  {
    return $this->title;
  }
}