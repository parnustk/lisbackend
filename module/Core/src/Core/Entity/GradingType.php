<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Core\Utils\EntityValidation;
use Doctrine\ORM\EntityManager;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\GradingTypeRepository")
 */
class GradingType extends EntityValidation
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Exclude()
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":255}})
     * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/^[a-zA-Z ]/"}})
     */
    protected $gradingType;

    /**
     * @ORM\ManyToMany(targetEntity="Module", mappedBy="gradingType")
     * @Annotation\Exclude()
     */
    protected $module;

    /**
     * @ORM\ManyToMany(targetEntity="Subject", mappedBy="gradingType")
     * @Annotation\Exclude()
     */
    protected $subject;

    /**
     * 
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em = null)
    {
        parent::__construct($em);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getGradingType()
    {
        return $this->gradingType;
    }

    public function getModule()
    {
        return $this->module;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setGradingType($gradingType)
    {
        $this->gradingType = $gradingType;
        return $this;
    }

    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

}
