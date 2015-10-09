<?php namespace Core\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     indexes={
 *         @ORM\Index(name="homeworkdate", columns={"duedate"}),
 *         @ORM\Index(name="independentworkduedate", columns={"duedate"})
 *     }
 * )
 */
class IndependentWork
{
    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $duedate;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $description;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $durationAK;

    /**
     * @ORM\OneToMany(targetEntity="GradeIndependentWork", mappedBy="independentWork")
     */
    protected $gradeIndependent;

    /**
     * @ORM\ManyToOne(targetEntity="SubjectRound", inversedBy="independentWork")
     * @ORM\JoinColumn(name="subject_round_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $subjectRound;

    /**
     * @ORM\ManyToOne(targetEntity="Teacher", inversedBy="independentWork")
     * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id", nullable=false)
     */
    protected $teacher;
}