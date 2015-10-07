<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Module
 *
 * @ORM\Table(name="module", indexes={@ORM\Index(name="fk_module_vocation_idx", columns={"vocation_id"}), @ORM\Index(name="fk_module_moduletype1_idx", columns={"moduletype_id"})})
 * @ORM\Entity
 */
class Module
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="duration", type="integer", nullable=false)
     */
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=45, nullable=false)
     */
    private $code;

    /**
     * @var \Core\Entity\Vocation
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Core\Entity\Vocation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vocation_id", referencedColumnName="id")
     * })
     */
    private $vocation;

    /**
     * @var \Core\Entity\Moduletype
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Core\Entity\Moduletype")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="moduletype_id", referencedColumnName="id")
     * })
     */
    private $moduletype;


}

