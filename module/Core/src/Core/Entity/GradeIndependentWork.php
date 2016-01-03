<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Doctrine\ORM\EntityManager;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\GradeIndependentWorkRepository")
 */
class GradeIndependentWork extends StudentGrade
{

    /**
     * @ORM\ManyToOne(targetEntity="IndependentWork", inversedBy="gradeIndependent")
     * @ORM\JoinColumn(name="independent_work_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     */
    protected $independentWork;

    /**
     * 
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em = null)
    {
        parent::__construct($em);
    }

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
