<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vocation
 *
 * @ORM\Table(name="vocation", uniqueConstraints={@ORM\UniqueConstraint(name="code_UNIQUE", columns={"code"})})
 * @ORM\Entity
 */
class Vocation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255, nullable=false)
     */
    private $code;

    /**
     * @var integer
     *
     * @ORM\Column(name="duration_ekap", type="integer", nullable=false)
     */
    private $durationEkap;


}

