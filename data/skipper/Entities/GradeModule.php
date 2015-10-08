<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class GradeModule extends StudentGrade
{
    /**
     * @ORM\ManyToOne(targetEntity="Module", inversedBy="gradeModule")
     * @ORM\JoinColumn(name="module_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     */
    private $module;
}