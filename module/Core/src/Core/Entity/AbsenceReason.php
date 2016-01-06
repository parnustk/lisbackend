<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Core\Utils\EntityValidation;
use Doctrine\ORM\EntityManager;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\AbsenceReasonRepository")
 */
class AbsenceReason extends EntityValidation
{

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Exclude()
     */
    protected $id;

    /**
     * 
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Annotation\Required({"required":"true"})
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Absence", mappedBy="absenceReason")
     */
    protected $absence;

    /**
     * @ORM\Column(type= "integer", nullable= true, options={"default":0})
     * @Annotation\Exclude()
     */
    protected $trashed;
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

    public function getAbsence()
    {
        return $this->absence;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setAbsence($absence)
    {
        $this->absence = $absence;
        return $this;
    }

}
