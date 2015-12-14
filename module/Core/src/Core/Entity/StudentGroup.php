<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Core\Utils\EntityValidation;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\StrudentGroupRepository")
 */
class StudentGroup extends EntityValidation
{

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="Vocation", inversedBy="studentGroup")
     * @ORM\JoinColumn(name="vocation_id", referencedColumnName="id", nullable=false, unique=true, onDelete="RESTRICT")
     */
    protected $vocation;

    /**
     * @ORM\OneToMany(targetEntity="SubjectRound", mappedBy="studentGroup")
     */
    protected $subjectRound;

    /**
     * @ORM\OneToMany(targetEntity="Student", mappedBy="studentGroup")
     */
    protected $student;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getVocation()
    {
        return $this->vocation;
    }

    public function getSubjectRound()
    {
        return $this->subjectRound;
    }

    public function getStudent()
    {
        return $this->student;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setVocation($vocation)
    {
        $this->vocation = $vocation;
        return $this;
    }

    public function setSubjectRound($subjectRound)
    {
        $this->subjectRound = $subjectRound;
        return $this;
    }

    public function setStudent($student)
    {
        $this->student = $student;
        return $this;
    }

}
