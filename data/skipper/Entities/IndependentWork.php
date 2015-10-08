<?php
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
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $duedate;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $durationAK;

    /**
     * @ORM\OneToMany(targetEntity="GradeIndependentWork", mappedBy="independentWork")
     */
    private $gradeIndependent;

    /**
     * @ORM\ManyToOne(targetEntity="SubjectRound", inversedBy="independentWork")
     * @ORM\JoinColumn(name="subject_round_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $subjectRound;
}