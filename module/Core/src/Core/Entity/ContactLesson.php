<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
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
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\ContactLessonRepository")
 * @ORM\Table(
 *      indexes={
 *          @ORM\Index(name="contactlesson_index_lessondate", columns={"lessonDate"}),
 *          @ORM\Index(name="contactlesson_trashed", columns={"trashed"}),
 *          @ORM\Index(name="contactlesson_description", columns={"description"}),
 *          @ORM\Index(name="contactlesson_durationAK", columns={"durationAK"}),
 * })
 * @ORM\HasLifecycleCallbacks
 */
class ContactLesson extends EntityValidation
{

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Exclude()
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Annotation\Required({"required":"true"})
     */
    protected $lessonDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Annotation\Required({"required":"true"})
     */
    protected $description;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Annotation\Required({"required":"true"})
     */
    protected $durationAK;

    /**
     * @ORM\OneToMany(targetEntity="Absence", mappedBy="contactLesson")
     */
    protected $absence;

    /**
     * @ORM\ManyToMany(targetEntity="Rooms", inversedBy="contactLesson")
     * @ORM\JoinTable(
     *     name="RoomsToContactLesson",
     *     joinColumns={@ORM\JoinColumn(name="contact_lesson_id", referencedColumnName="id", nullable=true)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="rooms_id", referencedColumnName="id", nullable=true)}
     * )
     */
    protected $rooms;

    /**
     * @ORM\OneToMany(targetEntity="StudentGrade", mappedBy="contactLesson")
     * @Annotation\Exclude()
     */
    protected $studentGrade;

    /**
     * @ORM\ManyToOne(targetEntity="SubjectRound", inversedBy="contactLesson")
     * @ORM\JoinColumn(name="subject_round_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * @Annotation\Required({"required":"true"})
     */
    protected $subjectRound;

    /**
     * @ORM\ManyToMany(targetEntity="Teacher", inversedBy="contactLesson")
     * @ORM\JoinTable(
     *     name="TeacherToContactLesson",
     *     joinColumns={@ORM\JoinColumn(name="contact_lesson_id", referencedColumnName="id", nullable=false)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="teacher_id", referencedColumnName="id", nullable=false)}
     * )
     * @Annotation\Required({"required":"true"})
     */
    protected $teacher;

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
     *
     * @ORM\Column(type="datetime", name="created_at", nullable=false)
     * @Annotation\Exclude()
     */
    protected $createdAt;

    /**
     *
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
        $this->teacher = new ArrayCollection();
        parent::__construct($em);
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

    public function getId()
    {
        return $this->id;
    }

    public function getLessonDate()
    {
        return $this->lessonDate;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDurationAK()
    {
        return $this->durationAK;
    }

    public function getAbsence()
    {
        return $this->absence;
    }

    public function getRooms()
    {
        return $this->rooms;
    }

    public function getStudentGrade()
    {
        return $this->studentGrade;
    }

    public function getSubjectRound()
    {
        return $this->subjectRound;
    }

    public function getTeacher()
    {
        return $this->teacher;
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

    public function setLessonDate($lessonDate)
    {
        $this->lessonDate = $lessonDate;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setDurationAK($durationAK)
    {
        $this->durationAK = $durationAK;
        return $this;
    }

    public function setAbsence($absence)
    {
        $this->absence = $absence;
        return $this;
    }

    public function setRooms($rooms)
    {
        $this->rooms = $rooms;
        return $this;
    }

    public function setStudentGrade($studentGrade)
    {
        $this->studentGrade = $studentGrade;
        return $this;
    }

    public function setSubjectRound($subjectRound = null)
    {
        $this->subjectRound = $subjectRound;
        return $this;
    }

    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;
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

}
