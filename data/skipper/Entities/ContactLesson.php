<?php
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
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $lessonDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $durationAK;

    /**
     * @ORM\OneToMany(targetEntity="Absence", mappedBy="contactLesson")
     */
    private $absence;

    /**
     * @ORM\ManyToOne(targetEntity="SubjectRound", inversedBy="contactLesson")
     * @ORM\JoinColumn(name="subject_round_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $subjectRound;

    /**
     * @ORM\ManyToOne(targetEntity="Rooms", inversedBy="contactLesson")
     * @ORM\JoinColumn(name="rooms_id", referencedColumnName="id")
     */
    private $rooms;
}