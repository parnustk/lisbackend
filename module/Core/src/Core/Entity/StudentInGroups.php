<?php

/**
 * LIS development
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis Team
 * @license   TODO
 */

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Core\Utils\EntityValidation;
use Doctrine\ORM\EntityManager;

/**
 * Description of StudentInGroups
 *
 * @author Sander Mets <sandermets0@gmail.com>
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\StudentGroupRepository")
 * @ORM\Table(
 *      indexes={
 *          @ORM\Index(name="studentingroups_index_trashed", columns={"trashed"}),
 *          @ORM\Index(name="studentingroups_index_status", columns={"status"})
 *      }
 * )
 * @ORM\HasLifecycleCallbacks
 */
class StudentInGroups extends EntityValidation
{

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Exclude()
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="studentInGroups")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     * @Annotation\Required({"required":"true"})
     */
    protected $student;

    /**
     * @ORM\ManyToOne(targetEntity="StudentGroup", inversedBy="studentInGroups")
     * @ORM\JoinColumn(name="student_group_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     * @Annotation\Required({"required":"true"})
     */
    protected $studentGroup;

    /**
     *
     * @ORM\Column(type="integer", nullable=false)
     * @Annotation\Required({"required":"true"})
     */
    protected $status;

    /**
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Annotation\Exclude()
     */
    protected $notes;

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
     *
     * @ORM\Column(type="datetime", name="created_at", nullable=false)
     * @Annotation\Exclude()
     */
    protected $createdAt;

    /**
     *
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

    public function getStudent()
    {
        return $this->student;
    }

    public function getStudentGroup()
    {
        return $this->studentGroup;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getNotes()
    {
        return $this->notes;
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

    public function setStudent($student)
    {
        $this->student = $student;
        return $this;
    }

    public function setStudentGroup($studentGroup)
    {
        $this->studentGroup = $studentGroup;
        return $this;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function setNotes($notes)
    {
        $this->notes = $notes;
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
