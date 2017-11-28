<?php

namespace EatingBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Class Consumption
 * @ORM\Entity
 * @ORM\Table(name="consumption")
 */
class Consumption
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="EatingBundle\Entity\User")
     */
    private $user;
    /**
     * @ORM\ManyToOne(targetEntity="EatingBundle\Entity\Products")
     */
    private $product_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $how_much;
    /**
     * @ORM\Column(type="string")
     */
    private $meals_of_the_day;
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @param mixed $product_id
     */
    public function setProductId(Products $product_id)
    {
        $this->product_id = $product_id;
    }

    /**
     * @return mixed
     */
    public function getHowMuch()
    {
        return $this->how_much;
    }

    /**
     * @param mixed $how_much
     */
    public function setHowMuch($how_much)
    {
        $this->how_much = $how_much;
    }

    /**
     * @return mixed
     */
    public function getMealsOfTheDay()
    {
        return $this->meals_of_the_day;
    }

    /**
     * @param mixed $meals_of_the_day
     */
    public function setMealsOfTheDay($meals_of_the_day)
    {
        $this->meals_of_the_day = $meals_of_the_day;
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
