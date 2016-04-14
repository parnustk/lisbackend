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
use Exception;
use Core\Entity\IndependentWork;
use Core\Entity\ContactLesson;
use Core\Entity\StudentGrade;
use Core\Entity\Subject;
use Core\Entity\StudentGroup;
use Core\Entity\Teacher;
use Core\Entity\LisUser;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\SubjectRoundRepository")
 * @ORM\Table(
 *     indexes={@ORM\Index(name="subjectround_index_trashed", columns={"trashed"})}
 * )
 * @ORM\HasLifecycleCallbacks
 * 
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class SubjectRound extends EntityValidation
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
    protected $name;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\OneToMany(targetEntity="IndependentWork", mappedBy="subjectRound")
     */
    protected $independentWork;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\OneToMany(targetEntity="ContactLesson", mappedBy="subjectRound")
     */
    protected $contactLesson;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\OneToMany(targetEntity="StudentGrade", mappedBy="subjectRound")
     */
    protected $studentGrade;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\ManyToOne(targetEntity="Subject", inversedBy="subjectRound")
     * @ORM\JoinColumn(name="subject_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     */
    protected $subject;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\ManyToOne(targetEntity="StudentGroup", inversedBy="subjectRound")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id", nullable=false)
     */
    protected $studentGroup;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\ManyToMany(targetEntity="Teacher", inversedBy="subjectRound")
     * @ORM\JoinTable(
     *     name="TeacherToSubjectRound",
     *     joinColumns={@ORM\JoinColumn(name="subject_round_id", referencedColumnName="id", nullable=false)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="teacher_id", referencedColumnName="id", nullable=false)}
     * )
     */
    protected $teacher;

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
        $this->teacher = new ArrayCollection();
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
    public function getName()
    {
        return $this->name;
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
     * @return ContactLesson
     */
    public function getContactLesson()
    {
        return $this->contactLesson;
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
     * @return Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * 
     * @return StudentGroup
     */
    public function getStudentGroup()
    {
        return $this->studentGroup;
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
     * @param int $id
     * @return \Core\Entity\SubjectRound
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * 
     * @param IndependentWork $independentWork
     * @return \Core\Entity\SubjectRound
     */
    public function setIndependentWork(IndependentWork $independentWork)
    {
        $this->independentWork = $independentWork;
        return $this;
    }

    /**
     * 
     * @param ContactLesson $contactLesson
     * @return \Core\Entity\SubjectRound
     */
    public function setContactLesson(ContactLesson $contactLesson)
    {
        $this->contactLesson = $contactLesson;
        return $this;
    }

    /**
     * 
     * @param StudentGrade $studentGrade
     * @return \Core\Entity\SubjectRound
     */
    public function setStudentGrade(StudentGrade $studentGrade)
    {
        $this->studentGrade = $studentGrade;
        return $this;
    }

    /**
     * 
     * @param Subject $subject
     * @return \Core\Entity\SubjectRound
     */
    public function setSubject(Subject $subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * 
     * @param StudentGroup $studentGroup
     * @return \Core\Entity\SubjectRound
     */
    public function setStudentGroup(StudentGroup $studentGroup)
    {
        $this->studentGroup = $studentGroup;
        return $this;
    }

    /**
     * 
     * @param Teacher $teacher
     * @return \Core\Entity\SubjectRound
     */
    public function setTeacher(Teacher $teacher)
    {
        $this->teacher = $teacher;
        return $this;
    }

    /**
     * 
     * @param int $trashed
     * @return \Core\Entity\SubjectRound
     */
    public function setTrashed($trashed)
    {
        $this->trashed = (int) $trashed;
        return $this;
    }

    /**
     * 
     * @param LisUser $createdBy
     * @return \Core\Entity\SubjectRound
     */
    public function setCreatedBy(LisUser $createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * 
     * @param LisUser $updatedBy
     * @return \Core\Entity\SubjectRound
     */
    public function setUpdatedBy(LisUser $updatedBy)
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    /**
     * 
     * @param DateTime $createdAt
     * @return \Core\Entity\SubjectRound
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * 
     * @param DateTime $updatedAt
     * @return \Core\Entity\SubjectRound
     */
    public function setUpdatedAt(DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @param Collection $teachers
     */
    public function addTeacher(Collection $teachers)
    {
        foreach ($teachers as $teacher) {
            if ($teacher instanceof \Core\Entity\Teacher) {
                $this->teacher->add($teacher);
            } else {
                throw new Exception('WRONG_TYPE');
            }
        }
    }

    /**
     * @param Collection $teachers
     */
    public function removeTeacher(Collection $teachers)
    {
        foreach ($teachers as $teacher) {
            $this->teacher->removeElement($teacher);
        }
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
