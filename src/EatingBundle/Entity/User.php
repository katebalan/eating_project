<?php

namespace EatingBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @UniqueEntity(fields={"email"}, message="It looks like you already have account!")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     * @ORM\Column(type="string", unique=true)
     */
    private $email;

    /**
     * The encoded password
     *
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * A non-persisted field that's used to create the encoded password.
     *
     * @Assert\NotBlank(groups={"Registration"})
     * @var string
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $second_name;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\Column(type="boolean")
     */
    private $gender;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="float")
     */
    private $weight;

    /**
     * @ORM\Column(type="float")
     */
    private $height;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $energy_exchange;

    /**
     * @ORM\Column(type="integer")
     */
    private $daily_kkal;

    /**
     * @ORM\Column(type="float")
     */
    private $daily_proteins;

    /**
     * @ORM\Column(type="float")
     */
    private $daily_fats;

    /**
     * @ORM\Column(type="float")
     */
    private $daily_carbohydrates;

    /**
     * @ORM\Column(type="integer")
     */
    private $current_kkal = 0;

    /**
     * @ORM\Column(type="float")
     */
    private $current_proteins = 0;

    /**
     * @ORM\Column(type="float")
     */
    private $current_fats = 0;

    /**
     * @ORM\Column(type="float")
     */
    private $current_carbohydrates = 0;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="EatingBundle\Entity\Consumption", mappedBy="user")
     */
    private $consumption;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\File(mimeTypes={ "image/jpg", "image/jpeg", "image/png" })
     */
    private $image;

    public function getUsername() {
        return $this->email;
    }

    public function getRoles()
    {
        $roles = $this->roles;

        // give EVERYONE ROLE_USER
        if(!in_array('ROLE_USER', $roles)) {
            $roles[] = 'ROLE_USER';
        }

        return $roles;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        // leaving blank - I don't need/have a password!
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        $this->password = null;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

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
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getSecondName()
    {
        return $this->second_name;
    }

    /**
     * @param mixed $second_name
     */
    public function setSecondName($second_name)
    {
        $this->second_name = $second_name;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param mixed $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return mixed
     */
    public function getEnergyExchange()
    {
        return $this->energy_exchange;
    }

    /**
     * @param mixed $energy_exchange
     */
    public function setEnergyExchange($energy_exchange)
    {
        $this->energy_exchange = $energy_exchange;
    }

    /**
     * @return mixed
     */
    public function getDailyKkal()
    {
        return $this->daily_kkal;
    }

    /**
     * @param mixed $daily_kkal
     */
    public function setDailyKkal($daily_kkal)
    {
        $this->daily_kkal = $daily_kkal;
    }

    /**
     * @return mixed
     */
    public function getDailyProteins()
    {
        return $this->daily_proteins;
    }

    /**
     * @param mixed $daily_proteins
     */
    public function setDailyProteins($daily_proteins)
    {
        $this->daily_proteins = $daily_proteins;
    }

    /**
     * @return mixed
     */
    public function getDailyFats()
    {
        return $this->daily_fats;
    }

    /**
     * @param mixed $daily_fats
     */
    public function setDailyFats($daily_fats)
    {
        $this->daily_fats = $daily_fats;
    }

    /**
     * @return mixed
     */
    public function getDailyCarbohydrates()
    {
        return $this->daily_carbohydrates;
    }

    /**
     * @param mixed $daily_carbohydrates
     */
    public function setDailyCarbohydrates($daily_carbohydrates)
    {
        $this->daily_carbohydrates = $daily_carbohydrates;
    }

    /**
     * @return mixed
     */
    public function getCurrentKkal()
    {
        return $this->current_kkal;
    }

    /**
     * @param mixed $current_kkal
     */
    public function setCurrentKkal($current_kkal)
    {
        $this->current_kkal = $current_kkal;
    }

    /**
     * @return mixed
     */
    public function getCurrentProteins()
    {
        return $this->current_proteins;
    }

    /**
     * @param mixed $current_proteins
     */
    public function setCurrentProteins($current_proteins)
    {
        $this->current_proteins = $current_proteins;
    }

    /**
     * @return mixed
     */
    public function getCurrentFats()
    {
        return $this->current_fats;
    }

    /**
     * @param mixed $current_fats
     */
    public function setCurrentFats($current_fats)
    {
        $this->current_fats = $current_fats;
    }

    /**
     * @return mixed
     */
    public function getCurrentCarbohydrates()
    {
        return $this->current_carbohydrates;
    }

    /**
     * @param mixed $current_carbohydrates
     */
    public function setCurrentCarbohydrates($current_carbohydrates)
    {
        $this->current_carbohydrates = $current_carbohydrates;
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
