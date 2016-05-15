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
use DateTime;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\StudentRepository")
 * @ORM\Table(
 *     indexes={
 *         @ORM\Index(name="studentcode", columns={"personalCode"}),
 *         @ORM\Index(name="studentfirstname", columns={"firstName"}),
 *         @ORM\Index(name="studentlastname", columns={"lastName"}),
 *         @ORM\Index(name="studentname", columns={"name"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks
 * 
 * @author Marten Kähr <marten@kahr.ee>
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Juhan Kõks <juhankoks@gmail.com>
 */
class Student extends EntityValidation
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
     * 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $firstName;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $lastName;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"EmailAddress"})
     * 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $email;

    /**
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StringTrim"})
     * 
     * @ORM\Column(type="string", unique=true, length=255, nullable=false)
     */
    protected $personalCode;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\OneToOne(targetEntity="LisUser", inversedBy="student")
     * @ORM\JoinColumn(name="lis_user_id", referencedColumnName="id")
     */
    protected $lisUser;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\OneToMany(targetEntity="Absence", mappedBy="student")
     */
    protected $absence;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\OneToMany(targetEntity="StudentGrade", mappedBy="student")
     */
    protected $studentGrade;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\OneToMany(targetEntity="StudentInGroups", mappedBy="student")
     */
    protected $studentInGroups;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\OneToMany(targetEntity="IndependentWork", mappedBy="student")
     */
    protected $independentWork;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $trashed;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\ManyToOne(targetEntity="LisUser")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=true)
     */
    protected $createdBy;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\ManyToOne(targetEntity="LisUser")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id", nullable=true)
     */
    protected $updatedBy;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\Column(type="datetime", name="created_at", nullable=false)
     */
    protected $createdAt;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     */
    protected $updatedAt;

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
     * @return String
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * 
     * @return String
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * 
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 
     * @return String
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * 
     * @return String
     */
    public function getPersonalCode()
    {
        return $this->personalCode;
    }

    /**
     * 
     * @return LisUser
     */
    public function getLisUser()
    {
        return $this->lisUser;
    }

    /**
     * 
     * @return Absence
     */
    public function getAbsence()
    {
        return $this->absence;
    }

    /**
     * 
     * @return StudentGrade
     */
    public function getStudentGrade()
    {
        return $this->studentGrade;
    }

    /**
     * 
     * @return StudentInGroups
     */
    public function getStudentInGroups()
    {
        return $this->studentInGroups;
    }

    /**
     * 
     * @return IndependentWork
     */
    public function getIndependentWork()
    {
        return $this->independentWork;
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
     * @return LisUser
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * 
     * @return LisUser
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * 
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * 
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * 
     * @param type $firstName
     * @return \Core\Entity\Student
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * 
     * @param type $lastName
     * @return \Core\Entity\Student
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * 
     * @param string $name
     * @return \Core\Entity\Student
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * 
     * @param type $email
     * @return \Core\Entity\Student
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * 
     * @param type $personalCode
     * @return \Core\Entity\Student
     */
    public function setPersonalCode($personalCode)
    {
        $this->personalCode = $personalCode;
        return $this;
    }

    /**
     * 
     * @param type $lisUser
     * @return \Core\Entity\Student
     */
    public function setLisUser($lisUser)
    {
        $this->lisUser = $lisUser;
        return $this;
    }

    /**
     * 
     * @param type $absence
     * @return \Core\Entity\Student
     */
    public function setAbsence($absence)
    {
        $this->absence = $absence;
        return $this;
    }

    /**
     * 
     * @param type $studentGrade
     * @return \Core\Entity\Student
     */
    public function setStudentGrade($studentGrade)
    {
        $this->studentGrade = $studentGrade;
        return $this;
    }

    /**
     * 
     * @param type $studentInGroups
     * @return \Core\Entity\Student
     */
    public function setStudentInGroups($studentInGroups)
    {
        $this->studentInGroups = $studentInGroups;
        return $this;
    }

    /**
     * 
     * @param type $independentWork
     * @return \Core\Entity\Student
     */
    public function setIndependentWork($independentWork)
    {
        $this->independentWork = $independentWork;
        return $this;
    }

    /**
     * 
     * @param type $trashed
     * @return \Core\Entity\Student
     */
    public function setTrashed($trashed)
    {
        $this->trashed = (int) $trashed;
        return $this;
    }

    /**
     * 
     * @param type $createdBy
     * @return \Core\Entity\Student
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * 
     * @param type $updatedBy
     * @return \Core\Entity\Student
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    /**
     * 
     * @param type $createdAt
     * @return \Core\Entity\Student
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * 
     * @param type $updatedAt
     * @return \Core\Entity\Student
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * 
     * @param type $id
     * @return \Core\Entity\Student
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function refreshTimeStamps()
    {
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new DateTime);
        } else {
            $this->setUpdatedAt(new DateTime);
        }
    }

}
