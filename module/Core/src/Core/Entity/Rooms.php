<?php namespace Core\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Rooms
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="ContactLesson", mappedBy="rooms")
     */
    protected $contactLesson;
}