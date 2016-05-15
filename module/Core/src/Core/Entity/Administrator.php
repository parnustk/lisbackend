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
use Core\Entity\LisUser;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\AdministratorRepository")
 * @ORM\Table(
 *     indexes={@ORM\Index(name="administrator_index_trashed", columns={"trashed"})}
 * )
 * @ORM\HasLifecycleCallbacks
 * 
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Marten Kähr <marten@kahr.ee>
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class Administrator extends EntityValidation
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
     * 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $firstName;

    /**
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StringTrim"})
     * 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $lastName;
    
    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"EmailAddress"})
     * 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $email;

    /**
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StringTrim"})
     * 
     * @ORM\Column(type="string", unique=true, length=255, nullable=false)
     */
    protected $personalCode;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\OneToOne(targetEntity="LisUser", inversedBy="administrator")
     * @ORM\JoinColumn(name="lis_user_id", referencedColumnName="id", nullable=true, unique=true)
     */
    protected $lisUser;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $superAdministrator = 0;

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
     * @return StringTrim
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * 
     * @return StringTrim
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    
    /**
     * 
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 
     * @return StringTrim
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * 
     * @return StringTrim
     */
    public function getPersonalCode()
    {
        return $this->personalCode;
    }

    /**
     * 
     * @return StringTrim
     */
    public function getLisUser()
    {
        return $this->lisUser;
    }

    /**
     * 
     * @return int
     */
    public function getSuperAdministrator()
    {
        return $this->superAdministrator;
    }

    /**
     * 
     * @return iny
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
     * @return \Core\Entity\Administrator
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }

    /**
     * 
     * @param StringTrim $firstName
     * @return \Core\Entity\Administrator
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * 
     * @param StringTrim $lastName
     * @return \Core\Entity\Administrator
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }
    
    /**
     * 
     * @param string $name
     * @return \Core\Entity\Administrator
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * 
     * @param StringTrim $email
     * @return \Core\Entity\Administrator
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * 
     * @param StringTrim $personalCode
     * @return \Core\Entity\Administrator
     */
    public function setPersonalCode($personalCode)
    {
        $this->personalCode = $personalCode;
        return $this;
    }

    /**
     * 
     * @param LisUser $lisUser
     * @return \Core\Entity\Administrator
     */
    public function setLisUser(LisUser $lisUser)
    {
        $this->lisUser = $lisUser;
        return $this;
    }

    /**
     * 
     * @param int $superAdministrator
     * @return \Core\Entity\Administrator
     */
    public function setSuperAdministrator($superAdministrator)
    {
        $this->superAdministrator = (int) $superAdministrator;
        return $this;
    }

    /**
     * 
     * @param int $trashed
     * @return \Core\Entity\Administrator
     */
    public function setTrashed($trashed)
    {
        $this->trashed = (int) $trashed;
        return $this;
    }

    /**
     * 
     * @param LisUser $createdBy
     * @return \Core\Entity\Administrator
     */
    public function setCreatedBy(LisUser $createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * 
     * @param LisUser $updatedBy
     * @return \Core\Entity\Administrator
     */
    public function setUpdatedBy(LisUser $updatedBy)
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    /**
     * 
     * @param DateTime $createdAt
     * @return \Core\Entity\Administrator
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * 
     * @param DateTime $updatedAt
     * @return \Core\Entity\Administrator
     */
    public function setUpdatedAt(DateTime $updatedAt)
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
