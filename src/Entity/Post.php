<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiSubresource;
use DateTimeImmutable;

/**
 *  @ApiResource(
 *     normalizationContext={"groups"={"post:read"}},
 *     denormalizationContext={"groups"={"post:write"}},
 *     attributes={
 *      "pagination_items_per_page"=10,
 *         "formats"={"jsonld", "json"}
 *     },
 *     itemOperations={
 *         "get"
 *     },
 *     collectionOperations={
 *         "get",
 *         "post",
 *     },
 * )
 * @ApiFilter(
 *          SearchFilter::class, properties={
 *                                  "city.id": "exact",
 *                                   "type.id": "exact",
 *
 *                               }
 *     )
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"post:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"post:read","post:write"})
     */
    private $description;

    /**
     * @ORM\Column(type="datetime",options={"default"="CURRENT_TIMESTAMP"})
     * @Groups({"post:read"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"post:read","post:write"})
     *
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity=PostType::class, inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"post:read","post:write"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"post:read","post:write"})
     */
    private $city;

    /**
     * @ORM\Column(type="datetime", nullable=true, columnDefinition="DATETIME on update CURRENT_TIMESTAMP")
     * @Groups({"post:read"})
     */
    private $updatedAt;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable('now');
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getType(): ?PostType
    {
        return $this->type;
    }

    public function setType(?PostType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }
}
