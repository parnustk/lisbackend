<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;

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
