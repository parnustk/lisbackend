<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class LisUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true, length=255, nullable=false)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $password;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $state;

    /**
     * @ORM\OneToOne(targetEntity="Teacher", mappedBy="lisUser")
     */
    protected $teacher;

    /**
     * @ORM\OneToOne(targetEntity="Student", mappedBy="lisUser")
     */
    protected $student;

    /**
     * @ORM\OneToOne(targetEntity="Administrator", mappedBy="lisUser")
     */
    protected $administrator;

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getTeacher()
    {
        return $this->teacher;
    }

    public function getStudent()
    {
        return $this->student;
    }

    public function getAdministrator()
    {
        return $this->administrator;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;
        return $this;
    }

    public function setStudent($student)
    {
        $this->student = $student;
        return $this;
    }

    public function setAdministrator($administrator)
    {
        $this->administrator = $administrator;
        return $this;
    }

}
