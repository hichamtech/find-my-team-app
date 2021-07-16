<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 *  * @ApiResource(
 *     normalizationContext={"groups"={"city:read"}},
 *     denormalizationContext={"groups"={"city:write"}},
 *     attributes={
 *      "pagination_items_per_page"=500,
 *         "formats"={"jsonld", "json"}
 *     },
 *     itemOperations={
 *         "get"
 *     },
 *     collectionOperations={
 *         "get"
 *     },
 * )
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CityRepository::class)
 */
class City
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"city:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"city:read"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="city")
     * @Groups({"city:read"})
     *
     */
    private $posts;

    /**
     * @ORM\ManyToOne(targetEntity=Region::class, inversedBy="cities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $region;

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
            $post->setCity($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getCity() === $this) {
                $post->setCity(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
       return $this->name;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

}
