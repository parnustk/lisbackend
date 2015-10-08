<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     indexes={@ORM\Index(name="subjectname", columns={"name"}),@ORM\Index(name="subjectcode", columns={"code"})}
 * )
 */
class Subject
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
    protected $code;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $durationAllAK;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $durationContactAK;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $durationIndependentAK;

    /**
     * @ORM\OneToMany(targetEntity="SubjectRound", mappedBy="subject")
     */
    protected $subjectRound;

    /**
     * @ORM\ManyToOne(targetEntity="Module", inversedBy="subject")
     * @ORM\JoinColumn(name="module_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $module;

    /**
     * @ORM\ManyToMany(targetEntity="GradingType", inversedBy="subject")
     * @ORM\JoinTable(
     *     name="GradingTypeToSubject",
     *     joinColumns={@ORM\JoinColumn(name="subject_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="grading_type_id", referencedColumnName="id", nullable=false)}
     * )
     */
    protected $gradingType;

    public function getId()
    {
        return $this->id;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDurationAllAK()
    {
        return $this->durationAllAK;
    }

    public function getDurationContactAK()
    {
        return $this->durationContactAK;
    }

    public function getDurationIndependentAK()
    {
        return $this->durationIndependentAK;
    }

    public function getSubjectRound()
    {
        return $this->subjectRound;
    }

    public function getModule()
    {
        return $this->module;
    }

    public function getGradingType()
    {
        return $this->gradingType;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setDurationAllAK($durationAllAK)
    {
        $this->durationAllAK = $durationAllAK;
        return $this;
    }

    public function setDurationContactAK($durationContactAK)
    {
        $this->durationContactAK = $durationContactAK;
        return $this;
    }

    public function setDurationIndependentAK($durationIndependentAK)
    {
        $this->durationIndependentAK = $durationIndependentAK;
        return $this;
    }

    public function setSubjectRound($subjectRound)
    {
        $this->subjectRound = $subjectRound;
        return $this;
    }

    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }

    public function setGradingType($gradingType)
    {
        $this->gradingType = $gradingType;
        return $this;
    }

}
