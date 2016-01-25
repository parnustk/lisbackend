<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Core\Utils\EntityValidation;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use DateTime;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\ModuleTypeRepository")
 * @ORM\Table(
 *  indexes={
 *      @ORM\Index(name="moduletype_index_trashed", columns={"trashed"})
 *      }
 * )
 * @ORM\HasLifecycleCallbacks
 */
class ModuleType extends EntityValidation
{

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Exclude()
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Annotation\Required({"required":"true"})
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Module", mappedBy="moduleType")
     */
    protected $module;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Annotation\Exclude()
     */
    protected $trashed;
    
    /**
     * @ORM\ManyToOne(targetEntity="LisUser")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id",nullable=true)
     */
    protected $createdBy;
    
    /**
     * @ORM\ManyToOne(targetEntity="LisUser")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id",nullable=true)
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

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getModule()
    {
        return $this->module;
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
    
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function refreshTimeStamps()
    {
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new DateTime);
        }
        $this->setUpdatedAt(new DateTime);
    }
}
