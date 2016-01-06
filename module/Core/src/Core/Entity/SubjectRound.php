<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Core\Utils\EntityValidation;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\SubjectRoundRepository")
 * @ORM\Table(
 *     indexes={@ORM\Index(name="index_trashed", columns={"trashed"})}
 * )
 */
class SubjectRound extends EntityValidation
{

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Exclude()
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
     * @Annotation\Required({"required":"true"})
     */
    protected $subject;

    /**
     * @ORM\ManyToOne(targetEntity="StudentGroup", inversedBy="subjectRound")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id", nullable=false)
     * @Annotation\Required({"required":"true"})
     */
    protected $studentGroup;

    /**
     * @ORM\ManyToMany(targetEntity="Teacher", inversedBy="subjectRound")
     * @ORM\JoinTable(
     *     name="TeacherToSubjectRound",
     *     joinColumns={@ORM\JoinColumn(name="subject_round_id", referencedColumnName="id", nullable=false)},
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
     * @return type
     */
    public function getTrashed()
    {
        return $this->trashed;
    }

    /**
     * 
     * @param type $trashed
     * @return \Core\Entity\SubjectRound
     */
    public function setTrashed($trashed)
    {
        $this->trashed = $trashed;
        return $this;
    }

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
