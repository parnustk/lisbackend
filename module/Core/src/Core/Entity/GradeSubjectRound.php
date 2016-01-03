<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Doctrine\ORM\EntityManager;

/**
 * @ORM\Entity
 */
class GradeSubjectRound extends StudentGrade
{

    /**
     * @ORM\ManyToOne(targetEntity="SubjectRound", inversedBy="gradeSubjectRound")
     * @ORM\JoinColumn(name="subject_round_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     */
    protected $subjectRound;

    /**
     * 
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em = null)
    {
        parent::__construct($em);
    }

    public function getSubjectRound()
    {
        return $this->subjectRound;
    }

    public function setSubjectRound($subjectRound)
    {
        $this->subjectRound = $subjectRound;
        return $this;
    }

}
