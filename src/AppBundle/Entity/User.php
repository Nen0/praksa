<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use AppBundle\Entity\Novost;

/**
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */

class User implements UserInterface
{
    /**
     * @ORM\Id;
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=40)
     */
    protected $name;    
   
    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $role;

    /**
     * @Assert\Length(max=4096)
     */
    protected $plainPassword;

     /**
     * 
     * @ORM\ManyToOne(targetEntity="Studij")
     * @ORM\JoinColumn(name="smijer", referencedColumnName="id", onDelete="CASCADE")
     */
    private $smijer;   
    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="mentor", referencedColumnName="id", onDelete="CASCADE")
     */
    private $mentor;    

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected $password;

    /**
     * @ORM\Column(type="string",nullable=true, length=40)
     */
    protected $address;
    /**
     * @ORM\Column(type="string",nullable=true, length=40)
     */
    protected $zip;
    /**
     * @ORM\Column(type="string",nullable=true, length=40)
     */
    protected $grad;
    /**
     * @ORM\Column(type="string", nullable=true, length=1024)
     */
    protected $iskustvo;     
     /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Struka")
     * @ORM\JoinColumn(name="obrazovanje", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $obrazovanje;
    /**
     * @ORM\Column(type="string",nullable=true, length=1024)
     */
    protected $vjestine;
    /**
     * @ORM\Column(type="string",nullable=true, length=100)
     */
    protected $jezici;
    /**
     * @ORM\Column(type="string", nullable=true, length=1024)
     */
    protected $ostalo;


    public function eraseCredentials()
    {
        return null;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role = null)
    {
        $this->role = $role;
    }

    public function getRoles()
    {
        return [$this->getRole()];
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }   
    
    public function getUsername()
    {
        return $this->email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }
    public function getSmijer()
    {
        return $this->smijer;
    }

    public function setSmijer($smijer)
    {
        $this->smijer = $smijer;
    }
    public function getNovost()
    {
        return $this->novost;
    }

    public function setNovost($novost)
    {
        $this->novost = $novost;
    }

    public function getSalt()
    {
        return null;
    }


    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     *
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }
    
    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }   

    /**
     * @return mixed
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param mixed $zip
     *
     * @return self
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGrad()
    {
        return $this->grad;
    }

    /**
     * @param mixed $grad
     *
     * @return self
     */
    public function setGrad($grad)
    {
        $this->grad = $grad;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIskustvo()
    {
        return $this->iskustvo;
    }

    /**
     * @param mixed $iskustvo
     *
     * @return self
     */
    public function setIskustvo($iskustvo)
    {
        $this->iskustvo = $iskustvo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getObrazovanje()
    {
        return $this->obrazovanje;
    }

    /**
     * @param mixed $obrazovanje
     *
     * @return self
     */
    public function setObrazovanje($obrazovanje)
    {
        $this->obrazovanje = $obrazovanje;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVjestine()
    {
        return $this->vjestine;
    }

    /**
     * @param mixed $vjestine
     *
     * @return self
     */
    public function setVjestine($vjestine)
    {
        $this->vjestine = $vjestine;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getJezici()
    {
        return $this->jezici;
    }

    /**
     * @param mixed $jezici
     *
     * @return self
     */
    public function setJezici($jezici)
    {
        $this->jezici = $jezici;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOstalo()
    {
        return $this->ostalo;
    }

    /**
     * @param mixed $ostalo
     *
     * @return self
     */
    public function setOstalo($ostalo)
    {
        $this->ostalo = $ostalo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMentor()
    {
        return $this->mentor;
    }

    /**
     * @param mixed $mentor
     *
     * @return self
     */
    public function setMentor($mentor)
    {
        $this->mentor = $mentor;

        return $this;
    }
}
