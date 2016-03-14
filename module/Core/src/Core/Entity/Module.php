<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Core\Utils\EntityValidation;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Zend\Stdlib\ArraySerializableInterface;
use DateTime;
use Core\Entity\GradingType;
use Core\Entity\ModuleType;
use Core\Entity\Vocation;
use Core\Entity\StudentGrade;
use Core\Entity\Subject;
use Core\Entity\LisUser;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\ModuleRepository")
 * @ORM\Table(
 *     indexes={
 *          @ORM\Index(name="modulename", columns={"name"}),
 *          @ORM\Index(name="modulecode", columns={"moduleCode"}),
 *          @ORM\Index(name="moduleduration", columns={"duration"}),
 *          @ORM\Index(name="module_trashed", columns={"trashed"}),
 * })
 * @ORM\HasLifecycleCallbacks
 * 
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class Module extends EntityValidation
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
     * 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $duration;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $moduleCode;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\OneToMany(targetEntity="Subject", mappedBy="module")
     */
    protected $subject;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\OneToMany(targetEntity="StudentGrade", mappedBy="module")
     */
    protected $studentGrade;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\ManyToOne(targetEntity="Vocation", inversedBy="module")
     * @ORM\JoinColumn(name="vocation_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $vocation;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\ManyToOne(targetEntity="ModuleType", inversedBy="module")
     * @ORM\JoinColumn(name="module_type_id", referencedColumnName="id", nullable=false)
     */
    protected $moduleType;

    /**
     * @Annotation\Required({"required":"true"})
     * 
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
     * @Annotation\Exclude()
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $trashed;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\ManyToOne(targetEntity="LisUser")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=true)
     */
    protected $createdBy;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\ManyToOne(targetEntity="LisUser")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id", nullable=true)
     */
    protected $updatedBy;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\Column(type="datetime", name="created_at", nullable=false)
     */
    protected $createdAt;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     */
    protected $updatedAt;

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
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 
     * @return integer
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * 
     * @return string
     */
    public function getModuleCode()
    {
        return $this->moduleCode;
    }

    /**
     * 
     * @return Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * 
     * @return StudentGrade
     */
    public function getStudentGrade()
    {
        return $this->studentGrade;
    }

    /**
     * 
     * @return Vocation
     */
    public function getVocation()
    {
        return $this->vocation;
    }

    /**
     * 
     * @return ModuleType
     */
    public function getModuleType()
    {
        return $this->moduleType;
    }

    /**
     * 
     * @return GradingType
     */
    public function getGradingType()
    {
        return $this->gradingType;
    }

    /**
     * 
     * @return int
     */
    public function getTrashed()
    {
        return $this->trashed;
    }

    /**
     * 
     * @return LisUser
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * 
     * @return LisUser
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * 
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * 
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * 
     * @param int $id
     * @return \Core\Entity\Module
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }

    /**
     * 
     * @param string $name
     * @return \Core\Entity\Module
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * 
     * @param integer $duration
     * @return \Core\Entity\Module
     */
    public function setDuration($duration)
    {
        $this->duration = (int) $duration;
        return $this;
    }

    /**
     * 
     * @param string $moduleCode
     * @return \Core\Entity\Module
     */
    public function setModuleCode($moduleCode)
    {
        $this->moduleCode = $moduleCode;
        return $this;
    }

    /**
     * 
     * @param Subject $subject
     * @return \Core\Entity\Module
     */
    public function setSubject(Subject $subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * 
     * @param StudentGrade $studentGrade
     * @return \Core\Entity\Module
     */
    public function setStudentGrade(StudentGrade $studentGrade)
    {
        $this->studentGrade = $studentGrade;
        return $this;
    }

    /**
     * 
     * @param Vocation $vocation
     * @return \Core\Entity\Module
     */
    public function setVocation(Vocation $vocation)
    {
        $this->vocation = $vocation;
        return $this;
    }

    /**
     * 
     * @param ModuleType $moduleType
     * @return \Core\Entity\Module
     */
    public function setModuleType(ModuleType $moduleType)
    {
        $this->moduleType = $moduleType;
        return $this;
    }

    /**
     * 
     * @param GradingType $gradingType
     * @return \Core\Entity\Module
     */
    public function setGradingType(GradingType $gradingType)
    {
        $this->gradingType = $gradingType;
        return $this;
    }

    /**
     * 
     * @param int $trashed
     * @return \Core\Entity\Module
     */
    public function setTrashed($trashed)
    {
        $this->trashed = (int) $trashed;
        return $this;
    }

    /**
     * 
     * @param \Core\Entity\LisUser $createdBy
     * @return \Core\Entity\Module
     */
    public function setCreatedBy(LisUser $createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * 
     * @param \Core\Entity\LisUser $updatedBy
     * @return \Core\Entity\Module
     */
    public function setUpdatedBy(LisUser $updatedBy)
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    /**
     * 
     * @param DateTime $createdAt
     * @return \Core\Entity\Module
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * 
     * @param DateTime $updatedAt
     * @return \Core\Entity\Module
     */
    public function setUpdatedAt(DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
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

    /**
     * First get inserted createdAt
     * and updatedAt stays NULL
     * 
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function refreshTimeStamps()
    {
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new DateTime);
        } else {
            $this->setUpdatedAt(new DateTime);
        }
    }

}
