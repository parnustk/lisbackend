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
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\GradeChoiceRepository")
 * @ORM\Table(indexes={@ORM\Index(name="gradechoice_index_trashed", columns={"trashed"})})
 * @ORM\HasLifecycleCallbacks
 * 
 * @author Arnold Tserepov <tserepov@gmail.com>
 */
class GradeChoice extends EntityValidation
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
     * @Annotation\Exclude()
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    protected $name;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\OneToMany(targetEntity="StudentGrade", mappedBy="gradeChoice")
     */
    protected $studentGrade;

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
     * @return Name
     */
    public function getName()
    {
        return $this->name;
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
     * @return \Core\Entity\GradeChoice
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }
    
    /**
     * 
     * @param string $name
     * @return \Core\Entity\GradeChoice
     */ 
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * 
     * @param StudentGrade $studentGrade
     * @return \Core\Entity\GradeChoice
     */
    public function setStudentGrade(StudentGrade $studentGrade)
    {
        $this->studentGrade = $studentGrade;
        return $this;
    }

     /**
     * 
     * @param int $trashed
     * @return \Core\Entity\GradeChoice
     */
    public function setTrashed($trashed)
    {
        $this->trashed = (int) $trashed;
        return $this;
    }

    /**
     * 
     * @param LisUser $createdBy
     * @return \Core\Entity\GradeChoice
     */
    public function setCreatedBy(LisUser $createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * 
     * @param LisUser $updatedBy
     * @return \Core\Entity\GradeChoice
     */
    public function setUpdatedBy(LisUser $updatedBy)
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

     /**
     * 
     * @param DateTime $createdAt
     * @return \Core\Entity\GradeChoice
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

     /**
     * 
     * @param DateTime $updatedAt
     * @return \Core\Entity\GradeChoice
     */
    public function setUpdatedAt(DateTime$updatedAt)
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
