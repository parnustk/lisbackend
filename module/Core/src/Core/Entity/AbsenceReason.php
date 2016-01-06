<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Core\Utils\EntityValidation;
use Doctrine\ORM\EntityManager;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\AbsenceReasonRepository")
 * @ORM\Table(
 *     indexes={@ORM\Index(name="index_trashed", columns={"trashed"})}
 * )
 *
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
     * @ORM\Column(type= "integer", nullable= true)
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

    /**
     * 
     * @param type $trashed
     * @return \Core\Entity\AbsenceReason
     */
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
