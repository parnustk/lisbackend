<?php namespace Core\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     indexes={
 *         @ORM\Index(name="teachercode", columns={"code"}),
 *         @ORM\Index(name="teacherfirstname", columns={"firstName"}),
 *         @ORM\Index(name="teacherlastname", columns={"lastName"})
 *     }
 * )
 */
class Teacher
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
     * @ORM\OneToOne(targetEntity="LisUser", inversedBy="teacher")
     * @ORM\JoinColumn(name="lis_user_id", referencedColumnName="id", unique=true)
     */
    protected $lisUser;

    /**
     * @ORM\OneToMany(targetEntity="IndependentWork", mappedBy="teacher")
     */
    protected $independentWork;

    /**
     * @ORM\OneToMany(targetEntity="StudentGrade", mappedBy="teacher")
     */
    protected $studentGrade;

    /**
     * @ORM\ManyToMany(targetEntity="SubjectRound", mappedBy="teacher")
     */
    protected $subjectRound;

    /**
     * @ORM\ManyToMany(targetEntity="ContactLesson", mappedBy="teacher")
     */
    protected $contactLesson;
}