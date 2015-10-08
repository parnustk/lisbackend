<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     indexes={@ORM\Index(name="vocationname", columns={"name"}),@ORM\Index(name="vocationcode", columns={"code"})}
 * )
 */
class Vocation
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
     * @ORM\Column(type="string", unique=true, length=255, nullable=false)
     */
    private $code;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $durationEKAP;

    /**
     * @ORM\OneToOne(targetEntity="Group", mappedBy="vocation")
     */
    private $group;

    /**
     * @ORM\OneToMany(targetEntity="Module", mappedBy="vocation")
     */
    private $module;
}