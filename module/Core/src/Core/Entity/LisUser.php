<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Core\Utils\EntityValidation;
use Doctrine\ORM\EntityManager;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\LisUserRepository")
 * @ORM\Table(
 *     indexes={@ORM\Index(name="lisuser_index_trashed", columns={"trashed"})}
 * )
 * 
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Juhan Kõks <juhankoks@gmail.com>
 */
class LisUser extends EntityValidation
{

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"EmailAddress"})
     * 
     * @ORM\Column(type="string", unique=true, length=255, nullable=false)
     */
    protected $email;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\Column(type="string", length=255, nullable=false)
     * 
     */
    protected $password;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\Column(type="integer", nullable=false, options={"default":1})
     * 
     */
    protected $state = 1;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\OneToOne(targetEntity="Teacher", mappedBy="lisUser")
     */
    protected $teacher;

    /**
     * @ORM\OneToOne(targetEntity="Student", mappedBy="lisUser")
     */
    protected $student;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\OneToOne(targetEntity="Administrator", mappedBy="lisUser")
     */
    protected $administrator;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $trashed;

    /**
     * 
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em = null)
    {
        parent::__construct($em);
    }

    /**
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * 
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * 
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * 
     * @return Teacher
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * 
     * @return Student
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * 
     * @return Administrator
     */
    public function getAdministrator()
    {
        return $this->administrator;
    }

    /**
     * 
     * @return int
     */
    public function getTrashed()
    {
        return $this->trashed;
    }

    /**
     * 
     * @param string $email
     * @return \Core\Entity\LisUser
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * 
     * @param string $password
     * @return \Core\Entity\LisUser
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * 
     * @param int $state
     * @return \Core\Entity\LisUser
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * 
     * @param Teacher $teacher
     * @return \Core\Entity\LisUser
     */
    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;
        return $this;
    }

    /**
     * 
     * @param int $id
     * @return \Core\Entity\LisUser
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * 
     * @param Student $student
     * @return \Core\Entity\LisUser
     */
    public function setStudent($student)
    {
        $this->student = $student;
        return $this;
    }

    /**
     * 
     * @param Administrator $administrator
     * @return \Core\Entity\LisUser
     */
    public function setAdministrator($administrator)
    {
        $this->administrator = $administrator;
        return $this;
    }

    /**
     * 
     * @param int $trashed
     * @return \Core\Entity\LisUser
     */
    public function setTrashed($trashed)
    {
        $this->trashed = (int) $trashed;
        return $this;
    }

}
