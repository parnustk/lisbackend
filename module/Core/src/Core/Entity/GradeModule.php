<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Doctrine\ORM\EntityManager;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\GradeModuleRepository")
 */
class GradeModule extends StudentGrade
{

    /**
     * @ORM\ManyToOne(targetEntity="Module", inversedBy="gradeModule")
     * @ORM\JoinColumn(name="module_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     */
    protected $module;

    /**
     * 
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em = null)
    {
        parent::__construct($em);
    }

    public function getModule()
    {
        return $this->module;
    }

    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }

}
