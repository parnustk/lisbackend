<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Core\Utils\EntityValidation;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Zend\Stdlib\ArraySerializableInterface;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\ModuleRepository")
 * @ORM\Table(
 *     indexes={@ORM\Index(name="modulename", columns={"name"}),@ORM\Index(name="modulecode", columns={"code"})}
 * )
 */
class Module extends EntityValidation
{

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Exclude()
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Annotation\Required({"required":"true"})
     */
    protected $name;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Annotation\Required({"required":"true"})
     */
    protected $duration;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Annotation\Required({"required":"true"})
     */
    protected $code;

    /**
     * @ORM\OneToMany(targetEntity="Subject", mappedBy="module")
     * @Annotation\Exclude()
     */
    protected $subject;

    /**
     * @ORM\OneToMany(targetEntity="StudentGrade", mappedBy="module")
     * @Annotation\Exclude()
     */
    protected $studentGrade;

    /**
     * @ORM\ManyToOne(targetEntity="Vocation", inversedBy="module")
     * @ORM\JoinColumn(name="vocation_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * @Annotation\Required({"required":"true"})
     */
    protected $vocation;

    /**
     * @ORM\ManyToOne(targetEntity="ModuleType", inversedBy="module")
     * @ORM\JoinColumn(name="module_type_id", referencedColumnName="id", nullable=false)
     * @Annotation\Required({"required":"true"})
     */
    protected $moduleType;

    /**
     * @Annotation\Required({"required":"true"})
     * @ORM\ManyToMany(targetEntity="GradingType", inversedBy="module")
     * @ORM\JoinTable(
     *     name="GradingTypeToModule",
     *     joinColumns={@ORM\JoinColumn(name="module_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="grading_type_id", referencedColumnName="id", nullable=false)}
     * )
     * 
     */
    protected $gradingType;

    /**
     * 
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em = null)
    {
        $this->gradingType = new ArrayCollection();
        parent::__construct($em);
    }

    /**
     * @param Collection $gradingTypes
     */
    public function addGradingType(Collection $gradingTypes)
    {
        foreach ($gradingTypes as $gradingType) {
            //$gradingType->setModule($this);
            $this->gradingType->add($gradingType);
        }
    }

    /**
     * @param Collection $gradingTypes
     */
    public function removeGradingType(Collection $gradingTypes)
    {
        foreach ($gradingTypes as $gradingType) {
            $this->gradingType->removeElement($gradingType);
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getVocation()
    {
        return $this->vocation;
    }

    public function getModuleType()
    {
        return $this->moduleType;
    }

    public function getGradingType()
    {
        return $this->gradingType;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
        return $this;
    }

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function setVocation($vocation)
    {
        $this->vocation = $vocation;
        return $this;
    }

    public function setModuleType($moduleType)
    {
        $this->moduleType = $moduleType;
        return $this;
    }

    public function getStudentGrade()
    {
        return $this->studentGrade;
    }

    public function setStudentGrade($studentGrade)
    {
        $this->studentGrade = $studentGrade;
        return $this;
    }

}
