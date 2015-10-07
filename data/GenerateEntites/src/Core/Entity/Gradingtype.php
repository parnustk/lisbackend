<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gradingtype
 *
 * @ORM\Table(name="gradingtype")
 * @ORM\Entity
 */
class Gradingtype
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
     * @ORM\Column(name="gradingtype", type="string", length=255, nullable=false)
     */
    private $gradingtype;


}

