<?php

namespace EatingBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Class Products
 * @ORM\Entity(repositoryClass="EatingBundle\Repository\ProductsRepository")
 * @ORM\Table(name="products")
 */
class Products
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
    private $kkal_per_100gr;

    /**
     * @ORM\Column(type="integer")
     */
    private $proteins_per_100gr;

    /**
     * @ORM\Column(type="integer")
     */
    private $fats_per_100gr;

    /**
     * @ORM\Column(type="integer")
     */
    private $carbohydrates_per_100gr;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rating;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

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
    public function getKkalPer100gr()
    {
        return $this->kkal_per_100gr;
    }

    /**
     * @param mixed $kkal_per_100gr
     */
    public function setKkalPer100gr($kkal_per_100gr)
    {
        $this->kkal_per_100gr = $kkal_per_100gr;
    }

    /**
     * @return mixed
     */
    public function getProteinsPer100gr()
    {
        return $this->proteins_per_100gr;
    }

    /**
     * @param mixed $proteins_per_100gr
     */
    public function setProteinsPer100gr($proteins_per_100gr)
    {
        $this->proteins_per_100gr = $proteins_per_100gr;
    }

    /**
     * @return mixed
     */
    public function getFatsPer100gr()
    {
        return $this->fats_per_100gr;
    }

    /**
     * @param mixed $fats_per_100gr
     */
    public function setFatsPer100gr($fats_per_100gr)
    {
        $this->fats_per_100gr = $fats_per_100gr;
    }

    /**
     * @return mixed
     */
    public function getCarbohydratesPer100gr()
    {
        return $this->carbohydrates_per_100gr;
    }

    /**
     * @param mixed $carbohydrates_per_100gr
     */
    public function setCarbohydratesPer100gr($carbohydrates_per_100gr)
    {
        $this->carbohydrates_per_100gr = $carbohydrates_per_100gr;
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

}
