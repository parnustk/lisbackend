<?php namespace Core\Entity;
use Doctrine\ORM\Mapping AS ORM; use Zend\Form\Annotation; 

/**
 * @ORM\Entity
 * @ORM\Table(indexes={@ORM\Index(name="moduletypename", columns={"name"})})
 */
class ModuleType
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
     * @ORM\OneToMany(targetEntity="Module", mappedBy="moduleType")
     */
    protected $module;
}