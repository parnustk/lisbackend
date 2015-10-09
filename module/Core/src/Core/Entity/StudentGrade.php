<?php namespace Core\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 */
class StudentGrade
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="studentGrade")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id", nullable=false)
     */
    protected $student;

    /**
     * @ORM\ManyToOne(targetEntity="GradeChoice", inversedBy="studentGrade")
     * @ORM\JoinColumn(name="grade_choice_id", referencedColumnName="id", nullable=false)
     */
    protected $gradeChoice;

    /**
     * @ORM\ManyToOne(targetEntity="Teacher", inversedBy="studentGrade")
     * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id", nullable=false)
     */
    protected $teacher;
}