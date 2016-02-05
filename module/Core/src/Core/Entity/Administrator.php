<?php

/**
 * LIS development
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis Team
 *
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
 * @author Marten Kähr <marten@kahr.ee>
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
     * @ORM\Column(type="encryptedstring", name="`code`", unique=true, length=255, nullable=false)
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
     * 
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em = null)
    {
        parent::__construct($em);
    }

    /**
     * 
     * @return type
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 
     * @return type
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * 
     * @return type
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * 
     * @return type
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * 
     * @return type
     */
    public function getLisUser()
    {
        return $this->lisUser;
    }

    /**
     * 
     * @return type
     */
    public function getTrashed()
    {
        return $this->trashed;
    }

    /**
     * 
     * @return type
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * 
     * @return type
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * 
     * @return type
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * 
     * @return type
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * 
     * @param type $firstName
     * @return \Core\Entity\Administrator
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * 
     * @param type $lastName
     * @return \Core\Entity\Administrator
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * 
     * @param type $code
     * @return \Core\Entity\Administrator
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * 
     * @param type $lisUser
     * @return \Core\Entity\Administrator
     */
    public function setLisUser($lisUser)
    {
        $this->lisUser = $lisUser;
        return $this;
    }

    /**
     * 
     * @param type $trashed
     * @return \Core\Entity\Administrator
     */
    public function setTrashed($trashed)
    {
        $this->trashed = $trashed;
        return $this;
    }

    /**
     * 
     * @param type $createdBy
     * @return \Core\Entity\Administrator
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * 
     * @param type $updatedBy
     * @return \Core\Entity\Administrator
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    /**
     * 
     * @param type $createdAt
     * @return \Core\Entity\Administrator
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * 
     * @param type $updatedAt
     * @return \Core\Entity\Administrator
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * Sets 'timestamps'
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
