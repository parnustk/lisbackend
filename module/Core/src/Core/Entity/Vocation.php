<?php

/**
 * LIS development
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis Team
 * @license   TODO
 */

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Core\Utils\EntityValidation;
use Doctrine\ORM\EntityManager;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\VocationRepository")
 * @ORM\Table(
 *     indexes={
 *          @ORM\Index(name="vocationname", columns={"name"}),
 *          @ORM\Index(name="vocationcode", columns={"code"}),
 *          @ORM\Index(name="vocation_index_trashed", columns={"trashed"})
 *     }
 * )
 */
class Vocation extends EntityValidation
{

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":"3", "max":"255"}})
     * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/[a-zA-Z]/"}})
     * 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\Column(type="string",name="`code`", unique=true, length=255, nullable=false)
     */
    protected $code;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $durationEKAP;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\OneToMany(targetEntity="StudentGroup", mappedBy="vocation")
     */
    protected $studentGroup;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\OneToMany(targetEntity="Module", mappedBy="vocation")
     */
    protected $module;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $trashed;

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

    public function getName()
    {
        return $this->name;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getDurationEKAP()
    {
        return $this->durationEKAP;
    }

    public function getStudentGroup()
    {
        return $this->studentGroup;
    }

    public function getModule()
    {
        return $this->module;
    }

    public function getTrashed()
    {
        return $this->trashed;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function setDurationEKAP($durationEKAP)
    {
        $this->durationEKAP = $durationEKAP;
        return $this;
    }

    public function setStudentGroup($studentGroup)
    {
        $this->studentGroup = $studentGroup;
        return $this;
    }

    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }

    public function setTrashed($trashed)
    {
        $this->trashed = $trashed;
        return $this;
    }

}
