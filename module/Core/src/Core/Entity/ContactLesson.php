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
use Core\Entity\Absence;
use Core\Entity\Rooms;
use Core\Entity\StudentGrade;
use Core\Entity\SubjectRound;
use Core\Entity\StudentGroup;
use Core\Entity\Teacher;
use Core\Entity\LisUser;
use Core\Entity\Module;
use Core\Entity\Vocation;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\ContactLessonRepository")
 * @ORM\Table(
 *      indexes={
 *          @ORM\Index(name="contactlesson_index_lessondate", columns={"lessonDate"}),
 *          @ORM\Index(name="contactlesson_trashed", columns={"trashed"}),
 *          @ORM\Index(name="contactlesson_description", columns={"description"}),
 *          @ORM\Index(name="contactlesson_name", columns={"name"}),
 *          @ORM\Index(name="contactlesson_sequenceNr", columns={"sequenceNr"})
 * })
 * @ORM\HasLifecycleCallbacks
 * 
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class ContactLesson extends EntityValidation
{

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $lessonDate;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $description;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $sequenceNr;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\OneToMany(targetEntity="Absence", mappedBy="contactLesson")
     */
    protected $absence;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\ManyToOne(targetEntity="Rooms", inversedBy="contactLesson")
     * @ORM\JoinColumn(name="rooms_id", referencedColumnName="id", nullable=false)
     */
    protected $rooms;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\OneToMany(targetEntity="StudentGrade", mappedBy="contactLesson")
     */
    protected $studentGrade;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\ManyToOne(targetEntity="SubjectRound", inversedBy="contactLesson")
     * @ORM\JoinColumn(name="subject_round_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $subjectRound;

    /**
     * @Annotation\Required({"required":"true"})

     * @ORM\ManyToOne(targetEntity="StudentGroup")
     * @ORM\JoinColumn(name="student_group_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * 
     */
    protected $studentGroup;

    /**
     * @Annotation\Required({"required":"true"})

     * @ORM\ManyToOne(targetEntity="Module")
     * @ORM\JoinColumn(name="module_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * 
     */
    protected $module;

    /**
     * @Annotation\Required({"required":"true"})

     * @ORM\ManyToOne(targetEntity="Vocation")
     * @ORM\JoinColumn(name="vocation_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * 
     */
    protected $vocation;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\ManyToOne(targetEntity="Teacher", inversedBy="contactLesson")
     * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
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
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 
     * @return datetime
     */
    public function getLessonDate()
    {
        return $this->lessonDate;
    }

    /**
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * 
     * @return int
     */
    public function getSequenceNr()
    {
        return $this->sequenceNr;
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
     * @return Rooms
     */
    public function getRooms()
    {
        return $this->rooms;
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
     * @return StudentGroup
     */
    public function getStudentGroup()
    {
        return $this->studentGroup;
    }

    /**
     * 
     * @return Module
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * 
     * @return Vocation
     */
    public function getVocation()
    {
        return $this->vocation;
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
     * @return \Core\Entity\ContactLesson
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }

    /**
     * 
     * @param string $name
     * @return \Core\Entity\ContactLesson
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * 
     * @param datetime $lessonDate
     * @return \Core\Entity\ContactLesson
     */
    public function setLessonDate($lessonDate)
    {
        $this->lessonDate = $lessonDate;
        return $this;
    }

    /**
     * 
     * @param sting $description
     * @return \Core\Entity\ContactLesson
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * 
     * @param integer $sequenceNr
     * @return \Core\Entity\ContactLesson
     */
    public function setSequenceNr($sequenceNr)
    {
        $this->sequenceNr = (int) $sequenceNr;
        return $this;
    }

    /**
     * 
     * @param Absence $absence
     * @return \Core\Entity\ContactLesson
     */
    public function setAbsence(Absence $absence)
    {
        $this->absence = $absence;
        return $this;
    }

    /**
     * 
     * @param Rooms $rooms
     * @return \Core\Entity\ContactLesson
     */
    public function setRooms(Rooms $rooms)
    {
        $this->rooms = $rooms;
        return $this;
    }

    /**
     * 
     * @param StudentGrade $studentGrade
     * @return \Core\Entity\ContactLesson
     */
    public function setStudentGrade(StudentGrade $studentGrade)
    {
        $this->studentGrade = $studentGrade;
        return $this;
    }

    /**
     * 
     * @param SubjectRound $subjectRound
     * @return \Core\Entity\ContactLesson
     */
    public function setSubjectRound(SubjectRound $subjectRound)
    {
        $this->subjectRound = $subjectRound;
        return $this;
    }

    /**
     * 
     * @param StudentGroup $studentGroup
     * @return \Core\Entity\ContactLesson
     */
    public function setStudentGroup(StudentGroup $studentGroup)
    {
        $this->studentGroup = $studentGroup;
        return $this;
    }

    /**
     * 
     * @param Module $module
     * @return \Core\Entity\ContactLesson
     */
    public function setModule(Module $module)
    {
        $this->module = $module;
        return $this;
    }

    /**
     * 
     * @param Vocation $vocation
     * @return \Core\Entity\ContactLesson
     */
    public function setVocation(Vocation $vocation)
    {
        $this->vocation = $vocation;
        return $this;
    }

    /**
     * 
     * @param Teacher $teacher
     * @return \Core\Entity\ContactLesson
     */
    public function setTeacher(Teacher $teacher)
    {
        $this->teacher = $teacher;
        return $this;
    }

    /**
     * 
     * @param int $trashed
     * @return \Core\Entity\ContactLesson
     */
    public function setTrashed($trashed)
    {
        $this->trashed = (int) $trashed;
        return $this;
    }

    /**
     * 
     * @param LisUser $createdBy
     * @return \Core\Entity\ContactLesson
     */
    public function setCreatedBy(LisUser $createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * 
     * @param LisUser $updatedBy
     * @return \Core\Entity\ContactLesson
     */
    public function setUpdatedBy(LisUser $updatedBy)
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    /**
     * 
     * @param DateTime $createdAt
     * @return \Core\Entity\ContactLesson
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * 
     * @param DateTime $updatedAt
     * @return \Core\Entity\ContactLesson
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
            //$gradingType->setModule($this);
            $this->teacher->add($teacher);
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
