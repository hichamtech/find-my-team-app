<?php

namespace App\Entity;

use App\Repository\PostTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"postType:read"}},
 *     denormalizationContext={"groups"={"postType:write"}},
 *     attributes={
 *      "pagination_items_per_page"=500,
 *         "formats"={"jsonld", "json"}
 *     },
 *     itemOperations={
 *        "get" = {
 *                   "path"="/post/type/{id}"
 *                },
 *     },
 *     collectionOperations={
 *        "get" = {
 *                   "path"="/post/type"
 *                  },
 *     },
 * )
 * @ORM\Entity(repositoryClass=PostTypeRepository::class)
 */
class PostType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"postType:read","post:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"postType:read","post:read"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="type")
     */
    private $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

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

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setType($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getType() === $this) {
                $post->setType(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
       return $this->name;
    }
}
