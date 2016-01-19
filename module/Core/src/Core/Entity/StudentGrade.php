<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Core\Utils\EntityValidation;
use Doctrine\ORM\EntityManager;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\StudentGradeRepository")
 */
class StudentGrade extends EntityValidation
{

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $notes;

    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="studentGrade")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id", nullable=false)
     */
    protected $student;

    /**
     * @ORM\ManyToOne(targetEntity="GradeChoice", inversedBy="studentGrade")
     * @ORM\JoinColumn(name="grade_choice_id", referencedColumnName="id", nullable=false)
     */
    protected $gradeChoice;

    /**
     * @ORM\ManyToOne(targetEntity="Teacher", inversedBy="studentGrade")
     * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id", nullable=false)
     */
    protected $teacher;

    /**
     * @ORM\ManyToOne(targetEntity="IndependentWork", inversedBy="studentGrade")
     * @ORM\JoinColumn(name="independent_work_id", referencedColumnName="id", onDelete="RESTRICT")
     */
    protected $independentWork;

    /**
     * @ORM\ManyToOne(targetEntity="Module", inversedBy="studentGrade")
     * @ORM\JoinColumn(name="module_id", referencedColumnName="id", onDelete="RESTRICT")
     */
    protected $module;

    /**
     * @ORM\ManyToOne(targetEntity="SubjectRound", inversedBy="studentGrade")
     * @ORM\JoinColumn(name="subject_round_id", referencedColumnName="id", onDelete="RESTRICT")
     */
    protected $subjectRound;

    /**
     * @ORM\ManyToOne(targetEntity="ContactLesson", inversedBy="studentGrade")
     * @ORM\JoinColumn(name="contact_lesson_id", referencedColumnName="id", onDelete="RESTRICT")
     */
    protected $contactLesson;

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

    public function getStudent()
    {
        return $this->student;
    }

    public function getGradeChoice()
    {
        return $this->gradeChoice;
    }

    public function getTeacher()
    {
        return $this->teacher;
    }

    public function setStudent($student)
    {
        $this->student = $student;
        return $this;
    }

    public function setGradeChoice($gradeChoice)
    {
        $this->gradeChoice = $gradeChoice;
        return $this;
    }

    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;
        return $this;
    }

}
