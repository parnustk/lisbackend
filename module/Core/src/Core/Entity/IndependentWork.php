<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Core\Utils\EntityValidation;
use Doctrine\ORM\EntityManager;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\IndependentWorkRepository")
 * @ORM\Table(
 *     indexes={
 *         @ORM\Index(name="homeworkdate", columns={"duedate"}),
 *         @ORM\Index(name="independentworkduedate", columns={"duedate"})
 *     }
 * )
 */
class IndependentWork extends EntityValidation
{

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $duedate;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $description;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $durationAK;

    /**
     * @ORM\OneToMany(targetEntity="GradeIndependentWork", mappedBy="independentWork")
     */
    protected $gradeIndependent;

    /**
     * @ORM\ManyToOne(targetEntity="SubjectRound", inversedBy="independentWork")
     * @ORM\JoinColumn(name="subject_round_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $subjectRound;

    /**
     * @ORM\ManyToOne(targetEntity="Teacher", inversedBy="independentWork")
     * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id", nullable=false)
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

    public function getDuedate()
    {
        return $this->duedate;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDurationAK()
    {
        return $this->durationAK;
    }

    public function getGradeIndependent()
    {
        return $this->gradeIndependent;
    }

    public function getSubjectRound()
    {
        return $this->subjectRound;
    }

    public function getTeacher()
    {
        return $this->teacher;
    }

    public function setDuedate($duedate)
    {
        $this->duedate = $duedate;
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

    public function setGradeIndependent($gradeIndependent)
    {
        $this->gradeIndependent = $gradeIndependent;
        return $this;
    }

    public function setSubjectRound($subjectRound)
    {
        $this->subjectRound = $subjectRound;
        return $this;
    }

    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;
        return $this;
    }

}
