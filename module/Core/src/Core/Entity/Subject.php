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
use Core\Entity\SubjectRound;
use Core\Entity\Module;
use Core\Entity\GradingType;
use Core\Entity\LisUser;

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
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
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
    public function getCode()
    {
        return $this->code;
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
     * @return int
     */
    public function getDurationAllAK()
    {
        return $this->durationAllAK;
    }

    /**
     * 
     * @return int
     */
    public function getDurationContactAK()
    {
        return $this->durationContactAK;
    }

    /**
     * 
     * @return int
     */
    public function getDurationIndependentAK()
    {
        return $this->durationIndependentAK;
    }

    /**
     * 
     * @return Subject
     */
    public function getSubjectRound()
    {
        return $this->subjectRound;
    }

    /**
     * 
     * @return Module
     */
    public function getModule()
    {
        return $this->module;
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
     * @return \Core\Entity\Subject
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }

    /**
     * 
     * @param string $code
     * @return \Core\Entity\Subject
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * 
     * @param string $name
     * @return \Core\Entity\Subject
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * 
     * @param int $durationAllAK
     * @return \Core\Entity\Subject
     */
    public function setDurationAllAK($durationAllAK)
    {
        $this->durationAllAK = (int) $durationAllAK;
        return $this;
    }

    /**
     * 
     * @param int $durationContactAK
     * @return \Core\Entity\Subject
     */
    public function setDurationContactAK($durationContactAK)
    {
        $this->durationContactAK = (int) $durationContactAK;
        return $this;
    }

    /**
     * 
     * @param int $durationIndependentAK
     * @return \Core\Entity\Subject
     */
    public function setDurationIndependentAK($durationIndependentAK)
    {
        $this->durationIndependentAK = (int) $durationIndependentAK;
        return $this;
    }

    /**
     * 
     * @param SubjectRound $subjectRound
     * @return \Core\Entity\Subject
     */
    public function setSubjectRound(SubjectRound $subjectRound)
    {
        $this->subjectRound = $subjectRound;
        return $this;
    }

    /**
     * 
     * @param Module $module
     * @return \Core\Entity\Subject
     */
    public function setModule(Module $module)
    {
        $this->module = $module;
        return $this;
    }

    /**
     * 
     * @param GradingType $gradingType
     * @return \Core\Entity\Subject
     */
    public function setGradingType(GradingType $gradingType)
    {
        $this->gradingType = $gradingType;
        return $this;
    }

    /**
     * 
     * @param int $trashed
     * @return \Core\Entity\Subject
     */
    public function setTrashed($trashed)
    {
        $this->trashed = (int) $trashed;
        return $this;
    }

    /**
     * 
     * @param LisUser $createdBy
     * @return \Core\Entity\Subject
     */
    public function setCreatedBy(LisUser $createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * 
     * @param LisUser $updatedBy
     * @return \Core\Entity\Subject
     */
    public function setUpdatedBy(LisUser $updatedBy)
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    /**
     * 
     * @param DateTime $createdAt
     * @return \Core\Entity\Subject
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * 
     * @param DateTime $updatedAt
     * @return \Core\Entity\Subject
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
