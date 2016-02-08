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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
 * @author Sander Mets <sandermets0@gmail.com>, Juhan Kõks <juhankoks@gmail.com>, Eleri Apsolon <eleri.apsolon@gmail.com>
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
     * 
     * @ORM\Column(type="encryptedstring", unique=true, length=255, nullable=false)
     */
    protected $personalCode;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\Column(type="encryptedstring", length=255, nullable=false)
     */
    protected $email;

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

    public function getPersonalCode()
    {
        return $this->personalCode;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getLisUser()
    {
        return $this->lisUser;
    }

    public function getIndependentWork()
    {
        return $this->independentWork;
    }

    public function getStudentGrade()
    {
        return $this->studentGrade;
    }

    public function getSubjectRound()
    {
        return $this->subjectRound;
    }

    public function getContactLesson()
    {
        return $this->contactLesson;
    }

    public function getTrashed()
    {
        return $this->trashed;
    }

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

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

    public function setPersonalCode($personalCode)
    {
        $this->personalCode = $personalCode;
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

    public function setIndependentWork($independentWork)
    {
        $this->independentWork = $independentWork;
        return $this;
    }

    public function setStudentGrade($studentGrade)
    {
        $this->studentGrade = $studentGrade;
        return $this;
    }

    public function setSubjectRound($subjectRound)
    {
        $this->subjectRound = $subjectRound;
        return $this;
    }

    public function setContactLesson($contactLesson)
    {
        $this->contactLesson = $contactLesson;
        return $this;
    }

    public function setTrashed($trashed)
    {
        $this->trashed = $trashed;
        return $this;
    }

    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

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
