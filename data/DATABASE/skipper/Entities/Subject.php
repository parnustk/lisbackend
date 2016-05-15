<?php
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
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $durationAllAK;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $durationContactAK;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $durationIndependentAK;

    /**
     * @ORM\OneToMany(targetEntity="SubjectRound", mappedBy="subject")
     */
    private $subjectRound;

    /**
     * @ORM\ManyToOne(targetEntity="Module", inversedBy="subject")
     * @ORM\JoinColumn(name="module_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $module;

    /**
     * @ORM\ManyToMany(targetEntity="GradingType", inversedBy="subject")
     * @ORM\JoinTable(
     *     name="GradingTypeToSubject",
     *     joinColumns={@ORM\JoinColumn(name="subject_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="grading_type_id", referencedColumnName="id", nullable=false)}
     * )
     */
    private $gradingType;
}