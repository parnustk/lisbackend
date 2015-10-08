<?php
use Doctrine\ORM\Mapping AS ORM;

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
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity="Vocation", inversedBy="group")
     * @ORM\JoinColumn(name="vocation_id", referencedColumnName="id", nullable=false, unique=true, onDelete="RESTRICT")
     */
    private $vocation;

    /**
     * @ORM\OneToMany(targetEntity="SubjectRound", mappedBy="group")
     */
    private $subjectRound;

    /**
     * @ORM\OneToMany(targetEntity="Student", mappedBy="group")
     */
    private $student;
}