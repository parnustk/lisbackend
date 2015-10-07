<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subject
 *
 * @ORM\Table(name="subject", indexes={@ORM\Index(name="fk_subject_module1_idx", columns={"module_id"})})
 * @ORM\Entity
 */
class Subject
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
     * @ORM\Column(name="code", type="string", length=255, nullable=false)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="duration_all_ak", type="integer", nullable=false)
     */
    private $durationAllAk;

    /**
     * @var integer
     *
     * @ORM\Column(name="duration_contact_ak", type="integer", nullable=false)
     */
    private $durationContactAk;

    /**
     * @var integer
     *
     * @ORM\Column(name="duration_independant_ak", type="integer", nullable=false)
     */
    private $durationIndependantAk;

    /**
     * @var \Core\Entity\Module
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Core\Entity\Module")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="module_id", referencedColumnName="id")
     * })
     */
    private $module;


}

