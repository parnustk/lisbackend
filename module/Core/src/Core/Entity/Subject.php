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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Core\Utils\EntityValidation;
use DateTime;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\SubjectRepository")
 * @ORM\Table(
 *     indexes={
 *          @ORM\Index(name="subjectname", columns={"name"}),
 *          @ORM\Index(name="subjectcode", columns={"code"}),
 *          @ORM\Index(name="subject_trashed", columns={"trashed"}),
 *          @ORM\Index(name="subject_durationAllAK", columns={"durationAllAK"}),
 *          @ORM\Index(name="subject_durationContactAK", columns={"durationContactAK"}),
 *          @ORM\Index(name="subject_durationIndependentAK", columns={"durationIndependentAK"}),
 * })
 * @ORM\HasLifecycleCallbacks
 * 
 * @author Sander Mets <sandermets0@gmail.com>, Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class Subject extends EntityValidation
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
    protected $code;

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
    protected $durationAllAK;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $durationContactAK;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $durationIndependentAK;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\OneToMany(targetEntity="SubjectRound", mappedBy="subject")
     */
    protected $subjectRound;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\ManyToOne(targetEntity="Module", inversedBy="subject")
     * @ORM\JoinColumn(name="module_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $module;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\ManyToMany(targetEntity="GradingType", inversedBy="subject")
     * @ORM\JoinTable(
     *     name="GradingTypeToSubject",
     *     joinColumns={@ORM\JoinColumn(name="subject_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="grading_type_id", referencedColumnName="id", nullable=false)}
     * )
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

    public function getId()
    {
        return $this->id;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDurationAllAK()
    {
        return $this->durationAllAK;
    }

    public function getDurationContactAK()
    {
        return $this->durationContactAK;
    }

    public function getDurationIndependentAK()
    {
        return $this->durationIndependentAK;
    }

    public function getSubjectRound()
    {
        return $this->subjectRound;
    }

    public function getModule()
    {
        return $this->module;
    }

    public function getGradingType()
    {
        return $this->gradingType;
    }

    public function getTrashed()
    {
        return $this->trashed;
    }

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setDurationAllAK($durationAllAK)
    {
        $this->durationAllAK = $durationAllAK;
        return $this;
    }

    public function setDurationContactAK($durationContactAK)
    {
        $this->durationContactAK = $durationContactAK;
        return $this;
    }

    public function setDurationIndependentAK($durationIndependentAK)
    {
        $this->durationIndependentAK = $durationIndependentAK;
        return $this;
    }

    public function setSubjectRound($subjectRound)
    {
        $this->subjectRound = $subjectRound;
        return $this;
    }

    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }

    public function setGradingType($gradingType)
    {
        $this->gradingType = $gradingType;
        return $this;
    }

    public function setTrashed($trashed)
    {
        $this->trashed = $trashed;
        return $this;
    }

    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setUpdatedAt($updatedAt)
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
