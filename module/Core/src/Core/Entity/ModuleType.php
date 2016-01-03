<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Core\Utils\EntityValidation;
use Doctrine\ORM\EntityManager;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\ModuleTypeRepository")
 * @ORM\Table(indexes={@ORM\Index(name="moduletypename", columns={"name"})})
 */
class ModuleType extends EntityValidation
{

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Exclude()
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":255}})
     * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/^[a-zA-Z ]/"}})
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Module", mappedBy="moduleType")
     * @Annotation\Exclude()
     */
    protected $module;

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

    public function getModule()
    {
        return $this->module;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }

}
