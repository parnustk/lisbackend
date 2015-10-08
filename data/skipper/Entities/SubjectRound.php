<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class SubjectRound
{
    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="IndependentWork", mappedBy="subjectRound")
     */
    private $independentWork;

    /**
     * @ORM\OneToMany(targetEntity="ContactLesson", mappedBy="subjectRound")
     */
    private $contactLesson;

    /**
     * @ORM\OneToMany(targetEntity="GradeSubjectRound", mappedBy="subjectRound")
     */
    private $gradeSubjectRound;

    /**
     * @ORM\ManyToOne(targetEntity="Teacher", inversedBy="subjectRound")
     * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     */
    private $teacher;

    /**
     * @ORM\ManyToOne(targetEntity="Subject", inversedBy="subjectRound")
     * @ORM\JoinColumn(name="subject_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     */
    private $subject;

    /**
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="subjectRound")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id", nullable=false)
     */
    private $group;
}