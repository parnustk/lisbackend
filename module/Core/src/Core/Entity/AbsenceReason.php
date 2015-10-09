<?php namespace Core\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class AbsenceReason
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Absence", mappedBy="absenceReason")
     */
    protected $absence;
}