<?php
/**
 * Created by PhpStorm.
 * User: katya
 * Date: 09.11.17
 * Time: 12:45
 */

namespace EatingBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{
    private $id;
    private $username;
    private $first_name;
    private $second_name;
    private $phone;
    private $email;
    private $weight;
    private $height;
    private $activity;
    private $daily_kkal;
    private $daily_proteins;
    private $daily_fats;
    private $daily_carbohydrates;
}