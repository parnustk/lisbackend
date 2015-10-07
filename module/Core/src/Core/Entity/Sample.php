<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;

/**
 * @author sander
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\SampleRepository")
 */
class Sample extends \Core\Utils\EntityValidation
{

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Exclude()
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":255}})
     * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/^[a-zA-Z ]/"}})
     */
    protected $name;

    /**
     * 
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function __construct(\Doctrine\ORM\EntityManager $em = null)
    {
        parent::__construct($em);
    }

    /**
     * 
     * @return type
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 
     * @return type
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 
     * @param type $name
     * @return \Core\Entity\Sample
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

}
