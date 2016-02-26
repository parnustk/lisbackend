<?php
use Doctrine\ORM\Mapping AS ORM;

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
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $duration;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity="Subject", mappedBy="module")
     */
    private $subject;

    /**
     * @ORM\OneToMany(targetEntity="GradeModule", mappedBy="module")
     */
    private $gradeModule;

    /**
     * @ORM\ManyToOne(targetEntity="Vocation", inversedBy="module")
     * @ORM\JoinColumn(name="vocation_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $vocation;

    /**
     * @ORM\ManyToOne(targetEntity="ModuleType", inversedBy="module")
     * @ORM\JoinColumn(name="module_type_id", referencedColumnName="id", nullable=false)
     */
    private $moduleType;

    /**
     * @ORM\ManyToMany(targetEntity="GradingType", inversedBy="module")
     * @ORM\JoinTable(
     *     name="GradingTypeToModule",
     *     joinColumns={@ORM\JoinColumn(name="module_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="grading_type_id", referencedColumnName="id", nullable=false)}
     * )
     */
    private $gradingType;
}