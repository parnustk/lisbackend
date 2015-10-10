<?php namespace Core\Entity;
use Doctrine\ORM\Mapping AS ORM; use Zend\Form\Annotation; 

/**
 * @ORM\Entity
 * @ORM\Table(
 *     indexes={@ORM\Index(name="modulename", columns={"name"}),@ORM\Index(name="modulecode", columns={"code"})}
 * )
 */
class Module
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
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $duration;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $code;

    /**
     * @ORM\OneToMany(targetEntity="Subject", mappedBy="module")
     */
    protected $subject;

    /**
     * @ORM\OneToMany(targetEntity="GradeModule", mappedBy="module")
     */
    protected $gradeModule;

    /**
     * @ORM\ManyToOne(targetEntity="Vocation", inversedBy="module")
     * @ORM\JoinColumn(name="vocation_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $vocation;

    /**
     * @ORM\ManyToOne(targetEntity="ModuleType", inversedBy="module")
     * @ORM\JoinColumn(name="module_type_id", referencedColumnName="id", nullable=false)
     */
    protected $moduleType;

    /**
     * @ORM\ManyToMany(targetEntity="GradingType", inversedBy="module")
     * @ORM\JoinTable(
     *     name="GradingTypeToModule",
     *     joinColumns={@ORM\JoinColumn(name="module_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="grading_type_id", referencedColumnName="id", nullable=false)}
     * )
     */
    protected $gradingType;
}