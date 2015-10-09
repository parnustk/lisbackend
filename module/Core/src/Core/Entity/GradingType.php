<?php namespace Core\Entity;
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
}