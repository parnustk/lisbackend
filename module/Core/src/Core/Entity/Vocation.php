<?php namespace Core\Entity;
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
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", unique=true, length=255, nullable=false)
     */
    protected $code;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $durationEKAP;

    /**
     * @ORM\OneToOne(targetEntity="Group", mappedBy="vocation")
     */
    protected $group;

    /**
     * @ORM\OneToMany(targetEntity="Module", mappedBy="vocation")
     */
    protected $module;
}