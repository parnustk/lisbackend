<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Moduletype
 *
 * @ORM\Table(name="moduletype")
 * @ORM\Entity
 */
class Moduletype
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


}

