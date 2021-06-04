<?php


namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class SearchPost
{
    /**
     *
     * @var ArrayCollection
     */

    private $city;

    private $postType;

    public function __construct()
    {
        $this->city = new ArrayCollection();
        $this->postType = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * @param ArrayCollection $city
     */
    public function setCity(ArrayCollection $city) {
        $this->city = $city;
    }

    /**
     * @return ArrayCollection
     */
    public function getPostType(): ArrayCollection
    {
        return $this->postType;
    }

    /**
     * @param ArrayCollection $postType
     */
    public function setPostType(ArrayCollection $postType): void
    {
        $this->postType = $postType;
    }


}