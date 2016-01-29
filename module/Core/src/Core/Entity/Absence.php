<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Core\Utils\EntityValidation;
use Doctrine\ORM\EntityManager;
use DateTime;

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\AbsenceRepository")
 * @ORM\Table(
 *     indexes={
 * @ORM\Index(name="absence_decription", columns={"description"}),
 * @ORM\Index(name="absence_index_trashed", columns={"trashed"})
 * 
 * }
 * )
 * @ORM\HasLifecycleCallbacks
 */
class Absence extends EntityValidation
{

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Annotation\Required({"required":"true"})
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $description;

    /**
     * @ORM\ManyToOne(targetEntity="AbsenceReason", inversedBy="absence")
     * @ORM\JoinColumn(name="absence_reason_id", referencedColumnName="id")
     */
    protected $absenceReason;

    /**
     * @Annotation\Required({"required":"true"})
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="absence")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id", nullable=false)
     */
    protected $student;

    /**
     * @Annotation\Required({"required":"true"})
     * @ORM\ManyToOne(targetEntity="ContactLesson", inversedBy="absence")
     * @ORM\JoinColumn(name="contact_lesson_id", referencedColumnName="id", nullable=false)
     */
    protected $contactLesson;

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

    public function getId()
    {
        return $this->id;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getAbsenceReason()
    {
        return $this->absenceReason;
    }

    public function getStudent()
    {
        return $this->student;
    }

    public function getContactLesson()
    {
        return $this->contactLesson;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setAbsenceReason($absenceReason)
    {
        $this->absenceReason = $absenceReason;
        return $this;
    }

    public function setStudent($student)
    {
        $this->student = $student;
        return $this;
    }

    public function setContactLesson($contactLesson)
    {
        $this->contactLesson = $contactLesson;
        return $this;
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
