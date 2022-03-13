<?php

namespace App\Entity;

use App\Repository\FilmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=FilmRepository::class)
 * @ApiResource(
 *   normalizationContext={"groups" = {"read"}},
 *   denormalizationContext={"groups" = {"write"}}
 * )
 * @ApiFilter(SearchFilter::class, properties={"name": "partial"})
 */
class Film
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     * @Groups({"read", "write"})
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"read", "write"})
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     * @Groups({"read", "write"})
     */
    private $date;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"read", "write"})
     */
    private $notation;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"read", "write"})
     */
    private $poster;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Groups({"read", "write"})
     */
    private $categories = [];

    public function getId(): ?int
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNotation(): ?float
    {
        return $this->notation;
    }

    public function setNotation(?float $notation): self
    {
        $this->notation = $notation;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getCategories(): ?array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): self
    {
        $this->categories = $categories;

        return $this;
    }
}
