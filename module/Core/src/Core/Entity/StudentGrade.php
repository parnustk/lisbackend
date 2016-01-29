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
use DateTime;

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\StudentGradeRepository")
 * @ORM\Table(
 *     indexes={@ORM\Index(name="studentgrade_index_trashed", columns={"trashed"})}
 * )
 * @ORM\HasLifecycleCallbacks
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
     * @Annotation\Required({"required":"true"})
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="studentGrade")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id", nullable=false)
     */
    protected $student;

    /**
     * @Annotation\Required({"required":"true"})
     * @ORM\ManyToOne(targetEntity="GradeChoice", inversedBy="studentGrade")
     * @ORM\JoinColumn(name="grade_choice_id", referencedColumnName="id", nullable=false)
     */
    protected $gradeChoice;

    /**
     * @Annotation\Required({"required":"true"})
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
        parent::__construct($em);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNotes()
    {
        return $this->notes;
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

    public function getIndependentWork()
    {
        return $this->independentWork;
    }

    public function getModule()
    {
        return $this->module;
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

    public function setNotes($notes)
    {
        $this->notes = $notes;
        return $this;
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

    public function setIndependentWork($independentWork)
    {
        $this->independentWork = $independentWork;
        return $this;
    }

    public function setModule($module)
    {
        $this->module = $module;
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

}
