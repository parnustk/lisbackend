<?php

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
 *         @ORM\Index(name="teachercode", columns={"code"}),
 *         @ORM\Index(name="teacherfirstname", columns={"firstName"}),
 *         @ORM\Index(name="teacherlastname", columns={"lastName"}),
 *         @ORM\Index(name="teachertrashed", columns={"trashed"}),
 *     }
 * )
 * @ORM\HasLifecycleCallbacks
 */
class Teacher extends EntityValidation
{

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Exclude()
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
     * @ORM\OneToOne(targetEntity="LisUser", inversedBy="teacher")
     * @ORM\JoinColumn(name="lis_user_id", referencedColumnName="id")
     */
    protected $lisUser;

    /**
     * @ORM\OneToMany(targetEntity="IndependentWork", mappedBy="teacher")
     */
    protected $independentWork;

    /**
     * @ORM\OneToMany(targetEntity="StudentGrade", mappedBy="teacher")
     */
    protected $studentGrade;

    /**
     * @ORM\ManyToMany(targetEntity="SubjectRound", mappedBy="teacher")
     */
    protected $subjectRound;

    /**
     * @ORM\ManyToMany(targetEntity="ContactLesson", mappedBy="teacher")
     */
    protected $contactLesson;

    /**
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Annotation\Exclude()
     */
    protected $trashed;

    /**
     *
     * @ORM\ManyToOne(targetEntity="LisUser")
     * @ORM\JoinColumn(name="createdBy", referencedColumnName="id",nullable=true)
     */
    protected $createdBy;

    /**
     *
     * @ORM\ManyToOne(targetEntity="LisUser")
     * @ORM\JoinColumn(name="updatedBy", referencedColumnName="id",nullable=true)
     */
    protected $updatedBy;

    /**
     * @ORM\Column(type="datetime", name="created_at", nullable=false)
     * @Annotation\Exclude() 
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", name="updated_at", nullable=false)
     * @Annotation\Exclude()
     */
    protected $updatedAt;

    /**
     * 
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em = null)
    {
//        $this->subjectRound = new ArrayCollection();
//        $this->contactLesson = new ArrayCollection();
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

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function refreshTimeStamps()
    {
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new DateTime);
        }
        $this->setUpdatedAt(new DateTime);
    }

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function getUpdatedBy()
    {
        return $this->updatedBy;
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

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTrashed($trashed)
    {
        $this->trashed = $trashed;
    }

    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

}
