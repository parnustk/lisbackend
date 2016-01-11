<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Core\Utils\EntityValidation;
use Doctrine\ORM\EntityManager;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\RoomsRepository")
 * @ORM\Table(
 *  indexes={
 *      @ORM\Index(name="roomname", columns={"name"}),
 *      @ORM\Index(name="room_index_trashed", columns={"trashed"})
 *      }
 * )
 */
class Rooms extends EntityValidation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Exclude()

     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Annotation\Required({"required":"true"})
     */
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="ContactLesson", mappedBy="rooms")
     */
    protected $contactLesson;
    
    /**
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Annotation\Exclude()
     */
    protected $trashed;
    
    /**
     * 
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em = null)
    {
        parent::__construct($em);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getContactLesson()
    {
        return $this->contactLesson;
    }
    
    /**
     * 
     * @return type
     */
     public function getTrashed()
    {
        return $this->trashed;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setContactLesson($contactLesson)
    {
        $this->contactLesson = $contactLesson;
        return $this;
    }
    
    public  function setTrashed($trashed)
    {
        $this->trashed = $trashed;
        return $this;
    }
}
