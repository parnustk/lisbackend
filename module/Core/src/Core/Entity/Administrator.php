<?php namespace Core\Entity;
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
     * @ORM\OneToOne(targetEntity="LisUser", inversedBy="administrator")
     * @ORM\JoinColumn(name="lis_user_id", referencedColumnName="id", nullable=false, unique=true)
     */
    protected $lisUser;
}