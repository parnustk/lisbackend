<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;

/**
 * @ORM\Entity
 */
class GradeIndependentWork extends StudentGrade
{

    /**
     * @ORM\ManyToOne(targetEntity="IndependentWork", inversedBy="gradeIndependent")
     * @ORM\JoinColumn(name="independent_work_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     */
    protected $independentWork;
    
    

}
