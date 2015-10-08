<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class SubjectRound
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
     * @ORM\ManyToOne(targetEntity="Teacher", inversedBy="subjectRound")
     * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     */
    protected $teacher;

    /**
     * @ORM\ManyToOne(targetEntity="Subject", inversedBy="subjectRound")
     * @ORM\JoinColumn(name="subject_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     */
    protected $subject;

    /**
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="subjectRound")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id", nullable=false)
     */
    protected $group;

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

    public function getTeacher()
    {
        return $this->teacher;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getGroup()
    {
        return $this->group;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
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

    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;
        return $this;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function setGroup($group)
    {
        $this->group = $group;
        return $this;
    }

}
