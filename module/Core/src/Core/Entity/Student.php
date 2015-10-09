<?php namespace Core\Entity;
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
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", unique=true, length=255, nullable=false)
     */
    protected $code;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $email;

    /**
     * @ORM\OneToOne(targetEntity="LisUser", inversedBy="student")
     * @ORM\JoinColumn(name="lis_user_id", referencedColumnName="id", unique=true)
     */
    protected $lisUser;

    /**
     * @ORM\OneToMany(targetEntity="Absence", mappedBy="student")
     */
    protected $absence;

    /**
     * @ORM\OneToMany(targetEntity="StudentGrade", mappedBy="student")
     */
    protected $studentGrade;

    /**
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="student")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     */
    protected $group;
}