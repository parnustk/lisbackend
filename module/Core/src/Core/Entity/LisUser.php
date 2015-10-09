<?php namespace Core\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class LisUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true, length=255, nullable=false)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $password;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $state;

    /**
     * @ORM\OneToOne(targetEntity="Teacher", mappedBy="lisUser")
     */
    protected $teacher;

    /**
     * @ORM\OneToOne(targetEntity="Student", mappedBy="lisUser")
     */
    protected $student;

    /**
     * @ORM\OneToOne(targetEntity="Administrator", mappedBy="lisUser")
     */
    protected $administrator;
}