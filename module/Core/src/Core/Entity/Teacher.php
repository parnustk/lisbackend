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
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\TeacherRepository")
 * @ORM\Table(
 *     indexes={
 *         @ORM\Index(name="teachercode", columns={"personalCode"}),
 *         @ORM\Index(name="teacherfirstname", columns={"firstName"}),
 *         @ORM\Index(name="teacherlastname", columns={"lastName"}),
 *         @ORM\Index(name="teachertrashed", columns={"trashed"}),
 *     }
 * )
 * @ORM\HasLifecycleCallbacks
 * 
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Juhan Kõks <juhankoks@gmail.com>
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class Teacher extends EntityValidation
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
     * @ORM\OneToOne(targetEntity="LisUser", inversedBy="teacher")
     * @ORM\JoinColumn(name="lis_user_id", referencedColumnName="id")
     */
    protected $lisUser;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\OneToMany(targetEntity="IndependentWork", mappedBy="teacher")
     */
    protected $independentWork;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\OneToMany(targetEntity="StudentGrade", mappedBy="teacher")
     */
    protected $studentGrade;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\ManyToMany(targetEntity="SubjectRound", mappedBy="teacher")
     */
    protected $subjectRound;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\ManyToMany(targetEntity="ContactLesson", mappedBy="teacher")
     */
    protected $contactLesson;

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
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * 
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * 
     * @return string
     */
    public function getPersonalCode()
    {
        return $this->personalCode;
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
     * @return LisUser
     */
    public function getLisUser()
    {
        return $this->lisUser;
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
     * @return StudentGrade
     */
    public function getStudentGrade()
    {
        return $this->studentGrade;
    }

    /**
     * 
     * @return SubjectRound
     */
    public function getSubjectRound()
    {
        return $this->subjectRound;
    }

    /**
     * 
     * @return ContactLesson
     */
    public function getContactLesson()
    {
        return $this->contactLesson;
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
     * @param string $firstName
     * @return \Core\Entity\Teacher
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * 
     * @param string $lastName
     * @return \Core\Entity\Teacher
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * 
     * @param string $personalCode
     * @return \Core\Entity\Teacher
     */
    public function setPersonalCode($personalCode)
    {
        $this->personalCode = $personalCode;
        return $this;
    }

    /**
     * 
     * @param string $email
     * @return \Core\Entity\Teacher
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * 
     * @param LisUser $lisUser
     * @return \Core\Entity\Teacher
     */
    public function setLisUser($lisUser)
    {
        $this->lisUser = $lisUser;
        return $this;
    }

    /**
     * 
     * @param IndependentWork $independentWork
     * @return \Core\Entity\Teacher
     */
    public function setIndependentWork($independentWork)
    {
        $this->independentWork = $independentWork;
        return $this;
    }

    /**
     * 
     * @param StudentGrade $studentGrade
     * @return \Core\Entity\Teacher
     */
    public function setStudentGrade($studentGrade)
    {
        $this->studentGrade = $studentGrade;
        return $this;
    }

    /**
     * 
     * @param SubjectRound $subjectRound
     * @return \Core\Entity\Teacher
     */
    public function setSubjectRound($subjectRound)
    {
        $this->subjectRound = $subjectRound;
        return $this;
    }

    /**
     * 
     * @param int $id
     * @return \Core\Entity\Teacher
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * 
     * @param ContactLesson $contactLesson
     * @return \Core\Entity\Teacher
     */
    public function setContactLesson($contactLesson)
    {
        $this->contactLesson = $contactLesson;
        return $this;
    }

    /**
     * 
     * @param int $trashed
     * @return \Core\Entity\Teacher
     */
    public function setTrashed($trashed)
    {
        $this->trashed = (int) $trashed;
        return $this;
    }

    /**
     * 
     * @param LisUser $createdBy
     * @return \Core\Entity\Teacher
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * 
     * @param LisUser $updatedBy
     * @return \Core\Entity\Teacher
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    /**
     * 
     * @param DateTime $createdAt
     * @return \Core\Entity\Teacher
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * 
     * @param DateTime $updatedAt
     * @return \Core\Entity\Teacher
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * First get inserted createdAt
     * and updatedAt stays NULL
     * 
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
