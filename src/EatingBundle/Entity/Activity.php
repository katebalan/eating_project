<?php

namespace EatingBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Activity
 * @ORM\Entity
 * @ORM\Table(name="activity")
 */
class Activity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $kkal_per_5minutes;

    /**
     * @ORM\Column(type="float")
     */
    private $proteins_per_5minutes;

    /**
     * @ORM\Column(type="float")
     */
    private $fats_per_5minutes;

    /**
     * @ORM\Column(type="float")
     */
    private $carbohydrates_per_5minutes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rating;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\File(mimeTypes={ "image/jpg", "image/jpeg", "image/png" })
     */
    private $image;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getKkalPer5minutes()
    {
        return $this->kkal_per_5minutes;
    }

    /**
     * @param mixed $kkal_per_5minutes
     */
    public function setKkalPer5minutes($kkal_per_5minutes)
    {
        $this->kkal_per_5minutes = $kkal_per_5minutes;
    }

    /**
     * @return mixed
     */
    public function getProteinsPer5minutes()
    {
        return $this->proteins_per_5minutes;
    }

    /**
     * @param mixed $proteins_per_5minutes
     */
    public function setProteinsPer5minutes($proteins_per_5minutes)
    {
        $this->proteins_per_5minutes = $proteins_per_5minutes;
    }

    /**
     * @return mixed
     */
    public function getFatsPer5minutes()
    {
        return $this->fats_per_5minutes;
    }

    /**
     * @param mixed $fats_per_5minutes
     */
    public function setFatsPer5minutes($fats_per_5minutes)
    {
        $this->fats_per_5minutes = $fats_per_5minutes;
    }

    /**
     * @return mixed
     */
    public function getCarbohydratesPer5minutes()
    {
        return $this->carbohydrates_per_5minutes;
    }

    /**
     * @param mixed $carbohydrates_per_5minutes
     */
    public function setCarbohydratesPer5minutes($carbohydrates_per_5minutes)
    {
        $this->carbohydrates_per_5minutes = $carbohydrates_per_5minutes;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }
}
