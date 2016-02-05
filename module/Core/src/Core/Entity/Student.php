<?php

/**
 * LIS development
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis Team
 * 
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
 *         @ORM\Index(name="studentcode", columns={"code"}),
 *         @ORM\Index(name="studentfirstname", columns={"firstName"}),
 *         @ORM\Index(name="studentlastname", columns={"lastName"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks
 * 
 * @author Marten Kähr <marten@kahr.ee>
 */
class Student extends EntityValidation
{

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Annotation\Required({"required":"true"})
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Annotation\Required({"required":"true"})
     */
    protected $lastName;

    /**
     * @ORM\Column(type="encryptedstring", name="`code`", unique=true, length=255, nullable=false)
     * @Annotation\Required({"required":"true"})
     */
    protected $code;

    /**
     * @ORM\Column(type="encryptedstring", length=255, nullable=false)
     * @Annotation\Required({"required":"true"})
     */
    protected $email;

    /**
     * @ORM\OneToOne(targetEntity="LisUser", inversedBy="student")
     * @ORM\JoinColumn(name="lis_user_id", referencedColumnName="id")
     */
    protected $lisUser;

    /**
     * @ORM\OneToMany(targetEntity="Absence", mappedBy="student")
     */
    protected $absence;

    /**
     * @ORM\OneToMany(targetEntity="StudentGrade", mappedBy="student")
     */
    protected $studentGrade;

    /**
     * @ORM\OneToMany(targetEntity="StudentInGroups", mappedBy="student")
     */
    protected $studentInGroups;

    /**
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Annotation\Exclude()
     */
    protected $trashed;
    
    /**
     * 
     * @ORM\ManyToOne(targetEntity="LisUser")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=true)
     */
    protected $createdBy;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="LisUser")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id", nullable=true)
     */
    protected $updatedBy;

    /**
     * @ORM\Column(type="datetime", name="created_at", nullable=false)
     * @Annotation\Exclude() 
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     * @Annotation\Exclude()
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

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getLisUser()
    {
        return $this->lisUser;
    }

    public function getAbsence()
    {
        return $this->absence;
    }

    public function getStudentGrade()
    {
        return $this->studentGrade;
    }

    public function getTrashed()
    {
        return $this->trashed;
    }

    /**
     * 
     * @return type
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * 
     * @return type
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * 
     * @return type
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * 
     * @return type
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setLisUser($lisUser)
    {
        $this->lisUser = $lisUser;
        return $this;
    }

    public function setAbsence($absence)
    {
        $this->absence = $absence;
        return $this;
    }

    public function setStudentGrade($studentGrade)
    {
        $this->studentGrade = $studentGrade;
        return $this;
    }

    public function setTrashed($trashed)
    {
        $this->trashed = $trashed;
        return $this;
    }

    public function getStudentInGroups()
    {
        return $this->studentInGroups;
    }

    public function setStudentInGroups($studentInGroups)
    {
        $this->studentInGroups = $studentInGroups;
        return $this;
    }

    /**
     * 
     * @param type $createdBy
     * @return \Core\Entity\Administrator
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * 
     * @param type $updatedBy
     * @return \Core\Entity\Administrator
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    /**
     * 
     * @param type $createdAt
     * @return \Core\Entity\Administrator
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * 
     * @param type $updatedAt
     * @return \Core\Entity\Administrator
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
    
    /**
     * Sets 'timestamps'
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function refreshTimeStamps()
    {
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new DateTime);
        }
        else {
        $this->setUpdatedAt(new DateTime);
        }
    }
}
