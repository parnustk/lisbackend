<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class GradingType
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $gradingType;

    /**
     * @ORM\ManyToMany(targetEntity="Module", mappedBy="gradingType")
     */
    protected $module;

    /**
     * @ORM\ManyToMany(targetEntity="Subject", mappedBy="gradingType")
     */
    protected $subject;

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

    public function setId($id)
    {
        $this->id = $id;
        return $this;
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
