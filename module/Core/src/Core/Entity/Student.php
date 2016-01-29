<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Core\Utils\EntityValidation;
use Doctrine\ORM\EntityManager;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\StudentRepository")
 * @ORM\Table(
 *     indexes={
 *         @ORM\Index(name="studentcode", columns={"code"}),
 *         @ORM\Index(name="studentfirstname", columns={"firstName"}),
 *         @ORM\Index(name="studentlastname", columns={"lastName"})
 *     }
 * )
 */
class Student extends EntityValidation
{

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Annotation\Required({"required":"true"})
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Annotation\Required({"required":"true"})
     */
    protected $lastName;

    /**
     * @ORM\Column(type="encryptedstring", name="`code`", unique=true, length=255, nullable=false)
     * @Annotation\Required({"required":"true"})
     */
    protected $code;

    /**
     * @ORM\Column(type="encryptedstring", length=255, nullable=false)
     * @Annotation\Required({"required":"true"})
     */
    protected $email;

    /**
     * @ORM\OneToOne(targetEntity="LisUser", inversedBy="student")
     * @ORM\JoinColumn(name="lis_user_id", referencedColumnName="id")
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
     * @ORM\OneToMany(targetEntity="StudentInGroups", mappedBy="student")
     */
    protected $studentInGroups;

    /**
     *
     * @ORM\Column(type="integer", nullable=true)
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

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getLisUser()
    {
        return $this->lisUser;
    }

    public function getAbsence()
    {
        return $this->absence;
    }

    public function getStudentGrade()
    {
        return $this->studentGrade;
    }

    public function getTrashed()
    {
        return $this->trashed;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setLisUser($lisUser)
    {
        $this->lisUser = $lisUser;
        return $this;
    }

    public function setAbsence($absence)
    {
        $this->absence = $absence;
        return $this;
    }

    public function setStudentGrade($studentGrade)
    {
        $this->studentGrade = $studentGrade;
        return $this;
    }

    public function setTrashed($trashed)
    {
        $this->trashed = $trashed;
        return $this;
    }

    public function getStudentInGroups()
    {
        return $this->studentInGroups;
    }

    public function setStudentInGroups($studentInGroups)
    {
        $this->studentInGroups = $studentInGroups;
        return $this;
    }

}
