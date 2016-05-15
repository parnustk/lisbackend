<?php
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
    private $subjectRound;
}