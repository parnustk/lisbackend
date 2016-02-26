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
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\IndependentWorkRepository")
 * @ORM\Table(
 *     indexes={
 *         @ORM\Index(name="independentwork_index_trashed", columns={"trashed"}),
 *         @ORM\Index(name="independentworkduedate", columns={"duedate"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks
 * 
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Kristen Sepp <seppkristen@gmail.com>
 */
class IndependentWork extends EntityValidation
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
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $duedate;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\Column(type="string", nullable=false)
     */
    protected $description;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $durationAK;

    /**
     * @Annotation\Exclude()

     * @ORM\OneToMany(targetEntity="StudentGrade", mappedBy="independentWork")
     */
    protected $studentGrade;

    /**
     * @Annotation\Required({"required":"true"})
     * 
     * @ORM\ManyToOne(targetEntity="SubjectRound", inversedBy="independentWork")
     * @ORM\JoinColumn(name="subject_round_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     */
    protected $subjectRound;

    /**
     * @ORM\ManyToOne(targetEntity="Teacher", inversedBy="independentWork")
     * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     * @Annotation\Required({"required":"true"})
     */
    protected $teacher;

    /**
     * @Annotation\Exclude()
     * 
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="independentWork")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id", nullable=true)
     */
    protected $student;

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

    public function getId()
    {
        return $this->id;
    }

    public function getDuedate()
    {
        return $this->duedate;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDurationAK()
    {
        return $this->durationAK;
    }

    public function getStudentGrade()
    {
        return $this->studentGrade;
    }

    public function getSubjectRound()
    {
        return $this->subjectRound;
    }

    public function getTeacher()
    {
        return $this->teacher;
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

    public function setDuedate($duedate)
    {
        $this->duedate = $duedate;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setDurationAK($durationAK)
    {
        $this->durationAK = $durationAK;
        return $this;
    }

    public function setStudentGrade($studentGrade)
    {
        $this->studentGrade = $studentGrade;
        return $this;
    }

    public function setSubjectRound($subjectRound)
    {
        $this->subjectRound = $subjectRound;
        return $this;
    }

    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;
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
