<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Core\Utils\EntityValidation;
use Doctrine\ORM\EntityManager;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\StudentGroupRepository")
 * @ORM\Table(
 *      indexes={@ORM\Index(name="index_trashed", columns={"trashed"})}
 * )
 */
class StudentGroup extends EntityValidation
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
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="Vocation", inversedBy="studentGroup")
     * @ORM\JoinColumn(name="vocation_id", referencedColumnName="id", nullable=false, unique=true, onDelete="RESTRICT")
     * @Annotation\Required({"required":"true"})
     */
    protected $vocation;

    /**
     * @ORM\OneToMany(targetEntity="SubjectRound", mappedBy="studentGroup")
     * @Annotation\Exclude()
     */
    protected $subjectRound;

    /**
     * @ORM\OneToMany(targetEntity="Student", mappedBy="studentGroup")
     * @Annotation\Exclude()
     */
    protected $student;
    
    /**
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Annotation\Exclude()
     */
    protected $trashed;
    
    /**
     * 
     * @return type 
     */
    public function getTrashed() 
    {
        return $this->trashed;
    }

    public function setTrashed($trashed) 
    {
        $this->trashed = $trashed;
        return $this;
    }

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
