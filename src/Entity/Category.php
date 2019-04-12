<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Articles", mappedBy="category")
     */
    private $array_articles;

    public function __construct()
    {
        $this->array_articles = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Articles[]
     */
    public function getArrayArticles(): Collection
    {
        return $this->array_articles;
    }

    public function addArrayArticle(Articles $arrayArticle): self
    {
        if (!$this->array_articles->contains($arrayArticle)) {
            $this->array_articles[] = $arrayArticle;
            $arrayArticle->setCategory($this);
        }

        return $this;
    }

    public function removeArrayArticle(Articles $arrayArticle): self
    {
        if ($this->array_articles->contains($arrayArticle)) {
            $this->array_articles->removeElement($arrayArticle);
            // set the owning side to null (unless already changed)
            if ($arrayArticle->getCategory() === $this) {
                $arrayArticle->setCategory(null);
            }
        }

        return $this;
    }
}
