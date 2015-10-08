<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     indexes={
 *         @ORM\Index(name="homeworkdate", columns={"duedate"}),
 *         @ORM\Index(name="independentworkduedate", columns={"duedate"})
 *     }
 * )
 */
class IndependentWork
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

    public function setId($id)
    {
        $this->id = $id;
        return $this;
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

}
