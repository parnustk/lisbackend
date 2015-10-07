<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subjectround
 *
 * @ORM\Table(name="subjectround", indexes={@ORM\Index(name="fk_subjectround_subject1_idx", columns={"subject_id"})})
 * @ORM\Entity
 */
class Subjectround
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var \Core\Entity\Subject
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Core\Entity\Subject")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subject_id", referencedColumnName="id")
     * })
     */
    private $subject;


}

