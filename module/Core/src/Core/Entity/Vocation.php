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
use DateTime;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\VocationRepository")
 * @ORM\Table(
 *     indexes={
 *          @ORM\Index(name="vocationname", columns={"name"}),
 *          @ORM\Index(name="vocationcode", columns={"vocationCode"}),
 *          @ORM\Index(name="vocation_index_trashed", columns={"trashed"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Juhan Kõks <juhankoks@gmail.com>
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
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
     * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/^[0-9\p{L}\s]{2,255}$/"}})
     * 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":"3", "max":"255"}})
     * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/^[0-9\p{L}]{2,255}$/"}})
     * 
     * @ORM\Column(type="string", unique=true, length=255, nullable=false)
     */
    protected $vocationCode;

    /**
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StringTrim"})
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
     * @return string
     */
    public function getVocationCode()
    {
        return $this->vocationCode;
    }

    /**
     * 
     * @return int
     */
    public function getDurationEKAP()
    {
        return $this->durationEKAP;
    }

    /**
     * 
     * @return StudentGroup
     */
    public function getStudentGroup()
    {
        return $this->studentGroup;
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
     * @param type $name
     * @return \Core\Entity\Vocation
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param type $id
     * @return \Core\Entity\Vocation
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * 
     * @param type $vocationCode
     * @return \Core\Entity\Vocation
     */
    public function setVocationCode($vocationCode)
    {
        $this->vocationCode = $vocationCode;
        return $this;
    }

    /**
     * 
     * @param type $durationEKAP
     * @return \Core\Entity\Vocation
     */
    public function setDurationEKAP($durationEKAP)
    {
        $this->durationEKAP = $durationEKAP;
        return $this;
    }

    /**
     * 
     * @param type $studentGroup
     * @return \Core\Entity\Vocation
     */
    public function setStudentGroup($studentGroup)
    {
        $this->studentGroup = $studentGroup;
        return $this;
    }

    /**
     * 
     * @param type $module
     * @return \Core\Entity\Vocation
     */
    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }

    /**
     * 
     * @param type $trashed
     * @return \Core\Entity\Vocation
     */
    public function setTrashed($trashed)
    {
        $this->trashed = (int) $trashed;
        return $this;
    }

    /**
     * 
     * @param type $createdBy
     * @return \Core\Entity\Vocation
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * 
     * @param type $updatedBy
     * @return \Core\Entity\Vocation
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    /**
     * 
     * @param type $createdAt
     * @return \Core\Entity\Vocation
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * 
     * @param type $updatedAt
     * @return \Core\Entity\Vocation
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
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
