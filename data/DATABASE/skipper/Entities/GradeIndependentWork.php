<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class GradeIndependentWork extends StudentGrade
{
    /**
     * @ORM\ManyToOne(targetEntity="IndependentWork", inversedBy="gradeIndependent")
     * @ORM\JoinColumn(name="independent_work_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     */
    private $independentWork;
}