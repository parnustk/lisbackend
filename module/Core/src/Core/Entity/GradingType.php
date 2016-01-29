<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Core\Utils\EntityValidation;
use Doctrine\ORM\EntityManager;
use DateTime;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\GradingTypeRepository")
 * @ORM\Table(
 *  indexes={
 *      @ORM\Index(name="gradingtype_index_trashed", columns={"trashed"}),
 *  }
 * )
 * @ORM\HasLifecycleCallbacks 
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
     * @ORM\Column(type="integer", nullable=true)
     * @Annotation\Exclude()
     */
    protected $trashed;
    
    /**
     * @ORM\ManyToOne(targetEntity="LisUser")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=true)
     */
    protected $createdBy;
    
    /**
     * @ORM\ManyToOne(targetEntity="LisUser")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id", nullable=true)
     */
    protected $updatedBy;
    
    /**
     * @ORM\Column(type="datetime", name="created_at", nullable=false)
     * @Annotation\Exclude()
     */
    protected $createdAt;
    
    /**
     * @ORM\Column(type="datetime", name="updated_at", nullable=false)
     * @Annotation\Exclude()
     */
    protected $updatedAt;
    
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
    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function refreshTimeStamps(){
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new DateTime);
        }
        $this->setUpdatedAt(new DateTime);
    }

}
