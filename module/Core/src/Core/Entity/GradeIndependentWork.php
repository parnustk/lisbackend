<?php

namespace Core\Entity;

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
    protected $independentWork;

    public function getIndependentWork()
    {
        return $this->independentWork;
    }

    public function setIndependentWork($independentWork)
    {
        $this->independentWork = $independentWork;
        return $this;
    }

}
