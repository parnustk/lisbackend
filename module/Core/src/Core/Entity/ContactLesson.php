<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Core\Utils\EntityValidation;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\ContactLessonRepository")
 * @ORM\Table(indexes={@ORM\Index(name="contactlessonlessondate", columns={"lessonDate"})})
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
     * @ORM\ManyToOne(targetEntity="SubjectRound", inversedBy="contactLesson")
     * @ORM\JoinColumn(name="subject_round_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * @Annotation\Required({"required":"true"})
     */
    protected $subjectRound;

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

    public function getSubjectRound()
    {
        return $this->subjectRound;
    }

    public function getRooms()
    {
        return $this->rooms;
    }

    public function getTeacher()
    {
        return $this->teacher;
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

    public function setSubjectRound($subjectRound)
    {
        $this->subjectRound = $subjectRound;
        return $this;
    }

    public function setRooms($rooms)
    {
        $this->rooms = $rooms;
        return $this;
    }

    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;
        return $this;
    }

    public function getStudentGrade()
    {
        return $this->studentGrade;
    }

    public function setStudentGrade($studentGrade)
    {
        $this->studentGrade = $studentGrade;
        return $this;
    }

}
