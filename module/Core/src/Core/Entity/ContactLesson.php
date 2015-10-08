<?php

namespace Core\Entity;

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
     * @ORM\ManyToOne(targetEntity="Rooms", inversedBy="contactLesson")
     * @ORM\JoinColumn(name="rooms_id", referencedColumnName="id")
     */
    protected $rooms;

    public function getId()
    {
        return $this->id;
    }

    public function getLessonDate()
    {
        return $this->lessonDate;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDurationAK()
    {
        return $this->durationAK;
    }

    public function getAbsence()
    {
        return $this->absence;
    }

    public function getSubjectRound()
    {
        return $this->subjectRound;
    }

    public function getRooms()
    {
        return $this->rooms;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setLessonDate($lessonDate)
    {
        $this->lessonDate = $lessonDate;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setDurationAK($durationAK)
    {
        $this->durationAK = $durationAK;
        return $this;
    }

    public function setAbsence($absence)
    {
        $this->absence = $absence;
        return $this;
    }

    public function setSubjectRound($subjectRound)
    {
        $this->subjectRound = $subjectRound;
        return $this;
    }

    public function setRooms($rooms)
    {
        $this->rooms = $rooms;
        return $this;
    }

}
