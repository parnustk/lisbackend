<?php

/**
 * LIS development
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis Team
 * @license   http://creativecommons.org/licenses/by-nc/4.0/legalcode Attribution-NonCommercial 4.0 International
 */

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Core\Utils\EntityValidation;
use Doctrine\ORM\EntityManager;
use DateTime;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\AdministratorRepository")
 * @ORM\Table(
 *     indexes={@ORM\Index(name="administrator_index_trashed", columns={"trashed"})}
 * )
 * @ORM\HasLifecycleCallbacks
 * @author Sander Mets <sandermets0@gmail.com>
 */
class Administrator extends EntityValidation
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
     * @Annotation\Filter({"name":"StringTrim"})
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StringTrim"})
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", unique=true, length=255, nullable=false)
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StringTrim"})
     */
    protected $code;

    /**
     * 
     * @ORM\OneToOne(targetEntity="LisUser", inversedBy="administrator")
     * @ORM\JoinColumn(name="lis_user_id", referencedColumnName="id", nullable=true, unique=true)
     */
    protected $lisUser;

    /**
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Annotation\Exclude()
     */
    protected $trashed;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="LisUser")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=true)
     */
    protected $createdBy;

    /**
     * 
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

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
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

//ALT+INSERT
//    protected $createdBy;
//    protected $updatedBy;
//    protected $createdAt;
//    protected $updatedAt;

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

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getLisUser()
    {
        return $this->lisUser;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function setLisUser($lisUser)
    {
        $this->lisUser = $lisUser;
        return $this;
    }

}
