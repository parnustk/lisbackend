<?php namespace Core\Entity;
use Doctrine\ORM\Mapping AS ORM; use Zend\Form\Annotation; 

/**
 * @ORM\Entity
 */
class Group
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
     * @ORM\ManyToOne(targetEntity="Vocation", inversedBy="group")
     * @ORM\JoinColumn(name="vocation_id", referencedColumnName="id", nullable=false, unique=true, onDelete="RESTRICT")
     */
    protected $vocation;

    /**
     * @ORM\OneToMany(targetEntity="SubjectRound", mappedBy="group")
     */
    protected $subjectRound;

    /**
     * @ORM\OneToMany(targetEntity="Student", mappedBy="group")
     */
    protected $student;
}