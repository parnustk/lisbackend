<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Administrator
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
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
     * @ORM\OneToOne(targetEntity="LisUser", inversedBy="administrator")
     * @ORM\JoinColumn(name="lis_user_id", referencedColumnName="id", nullable=false, unique=true)
     */
    private $lisUser;
}