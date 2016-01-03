<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Core\Utils\EntityValidation;
use Doctrine\ORM\EntityManager;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\SubjectRoundRepository")
 */
class SubjectRound extends EntityValidation
{

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="IndependentWork", mappedBy="subjectRound")
     */
    protected $independentWork;

    /**
     * @ORM\OneToMany(targetEntity="ContactLesson", mappedBy="subjectRound")
     */
    protected $contactLesson;

    /**
     * @ORM\OneToMany(targetEntity="GradeSubjectRound", mappedBy="subjectRound")
     */
    protected $gradeSubjectRound;

    /**
     * @ORM\ManyToOne(targetEntity="Subject", inversedBy="subjectRound")
     * @ORM\JoinColumn(name="subject_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     */
    protected $subject;

    /**
     * @ORM\ManyToOne(targetEntity="StudentGroup", inversedBy="subjectRound")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id", nullable=false)
     */
    protected $studentGroup;

    /**
     * @ORM\ManyToMany(targetEntity="Teacher", inversedBy="subjectRound")
     * @ORM\JoinTable(
     *     name="TeacherToSubjectRound",
     *     joinColumns={@ORM\JoinColumn(name="subject_round_id", referencedColumnName="id", nullable=false)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="teacher_id", referencedColumnName="id", nullable=false)}
     * )
     */
    protected $teacher;

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

    public function getIndependentWork()
    {
        return $this->independentWork;
    }

    public function getContactLesson()
    {
        return $this->contactLesson;
    }

    public function getGradeSubjectRound()
    {
        return $this->gradeSubjectRound;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getStudentGroup()
    {
        return $this->studentGroup;
    }

    public function getTeacher()
    {
        return $this->teacher;
    }

    public function setIndependentWork($independentWork)
    {
        $this->independentWork = $independentWork;
        return $this;
    }

    public function setContactLesson($contactLesson)
    {
        $this->contactLesson = $contactLesson;
        return $this;
    }

    public function setGradeSubjectRound($gradeSubjectRound)
    {
        $this->gradeSubjectRound = $gradeSubjectRound;
        return $this;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function setStudentGroup($studentGroup)
    {
        $this->studentGroup = $studentGroup;
        return $this;
    }

    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;
        return $this;
    }

}
