<?php namespace Core\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(indexes={@ORM\Index(name="contactlessonlessondate", columns={"lessonDate"})})
 */
class ContactLesson
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $lessonDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $description;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $durationAK;

    /**
     * @ORM\OneToMany(targetEntity="Absence", mappedBy="contactLesson")
     */
    protected $absence;

    /**
     * @ORM\ManyToOne(targetEntity="SubjectRound", inversedBy="contactLesson")
     * @ORM\JoinColumn(name="subject_round_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $subjectRound;

    /**
     * @ORM\ManyToMany(targetEntity="Rooms", inversedBy="contactLesson")
     * @ORM\JoinTable(
     *     name="RoomsToContactLesson",
     *     joinColumns={@ORM\JoinColumn(name="contact_lesson_id", referencedColumnName="id", nullable=false)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="rooms_id", referencedColumnName="id", nullable=false)}
     * )
     */
    protected $rooms;

    /**
     * @ORM\ManyToMany(targetEntity="Teacher", inversedBy="contactLesson")
     * @ORM\JoinTable(
     *     name="TeacherToContactLesson",
     *     joinColumns={@ORM\JoinColumn(name="contact_lesson_id", referencedColumnName="id", nullable=false)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="teacher_id", referencedColumnName="id", nullable=false)}
     * )
     */
    protected $teacher;
}