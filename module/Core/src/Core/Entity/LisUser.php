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
     * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/((?=.*\d)(?=.*[a-zA-Z]).{8,20})/"}})
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
     * @ORM\OneToMany(targetEntity="Student", mappedBy="lisUser")
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

    public function getTrashed()
    {
        return $this->trashed;
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

    public function setTrashed($trashed)
    {
        $this->trashed = $trashed;
        return $this;
    }

}
