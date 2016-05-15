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
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\StudentGroupRepository")
 * @ORM\Table(
 *      indexes={
 *          @ORM\Index(name="studentgroup_index_trashed", columns={"trashed"})
 *      }
 * )
 * @ORM\HasLifecycleCallbacks
 * 
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Kristen Sepp <seppkristen@gmail.com>
 * @author Arnold Tserepov <tserepov@gmail.com>
 */
class StudentGroup extends EntityValidation
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
     * @ORM\ManyToOne(targetEntity="Vocation", inversedBy="studentGroup")
     * @ORM\JoinColumn(name="vocation_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     */
    protected $vocation;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\OneToMany(targetEntity="SubjectRound", mappedBy="studentGroup")
     */
    protected $subjectRound;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\OneToMany(targetEntity="StudentInGroups", mappedBy="studentGroup")
     */
    protected $studentInGroups;

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
     * @return Vocation
     */
    public function getVocation()
    {
        return $this->vocation;
    }

    /**
     * 
     * @return SubjectRound
     */
    public function getSubjectRound()
    {
        return $this->subjectRound;
    }

    /**
     * 
     * @return StudentInGroups
     */
    public function getStudentInGroups()
    {
        return $this->studentInGroups;
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
     * @return \Core\Entity\StudentGroup
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }
    /**
     * 
     * @param string $name
     * @return \Core\Entity\StudentGroup
     */ 
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

     /**
     * 
     * @param Vocation $vocation
     * @return \Core\Entity\StudentGroup
     */
    public function setVocation(Vocation $vocation)
    {
        $this->vocation = $vocation;
        return $this;
    }

     /**
     * 
     * @param SubjectRound $subjectRound
     * @return \Core\Entity\StudentGroup
     */
    public function setSubjectRound(SubjectRound $subjectRound)
    {
        $this->subjectRound = $subjectRound;
        return $this;
    }

     /**
     * 
     * @param StudentInGroups $studentInGroups
     * @return \Core\Entity\StudentGroup
     */
    public function setStudentInGroups(StudentInGroups $studentInGroups)
    {
        $this->studentInGroups = $studentInGroups;
        return $this;
    }
    
    /**
     * 
     * @param int $trashed
     * @return \Core\Entity\StudentGroup
     */
    public function setTrashed($trashed)
    {
        $this->trashed = (int) $trashed;
        return $this;
    }

     /**
     * 
     * @param LisUser $createdBy
     * @return \Core\Entity\StudentGroup
     */
    public function setCreatedBy(LisUser $createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

     /**
     * 
     * @param LisUser $updatedBy
     * @return \Core\Entity\StudentGroup
     */
    public function setUpdatedBy(LisUser $updatedBy)
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    /**
     * 
     * @param DateTime $createdAt
     * @return \Core\Entity\StudentGroup
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * 
     * @param DateTime $updatedAt
     * @return \Core\Entity\StudentGroup
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
