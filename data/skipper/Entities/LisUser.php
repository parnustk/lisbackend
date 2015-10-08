<?php
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
    private $id;

    /**
     * @ORM\Column(type="string", unique=true, length=255, nullable=false)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $state;

    /**
     * @ORM\OneToOne(targetEntity="Teacher", mappedBy="lisUser")
     */
    private $teacher;

    /**
     * @ORM\OneToOne(targetEntity="Student", mappedBy="lisUser")
     */
    private $student;

    /**
     * @ORM\OneToOne(targetEntity="Administrator", mappedBy="lisUser")
     */
    private $administrator;
}