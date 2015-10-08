<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     indexes={
 *         @ORM\Index(name="studentcode", columns={"code"}),
 *         @ORM\Index(name="studentfirstname", columns={"firstName"}),
 *         @ORM\Index(name="studentlastname", columns={"lastName"})
 *     }
 * )
 */
class Student
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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", unique=true, length=255, nullable=false)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="Absence", mappedBy="student")
     */
    private $absence;

    /**
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="student")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     */
    private $group;
}