<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SubjectHasGradingtype
 *
 * @ORM\Table(name="subject_has_gradingtype", indexes={@ORM\Index(name="fk_subject_has_gradingtype_subject1_idx", columns={"subject_id"}), @ORM\Index(name="fk_subject_has_gradingtype_gradingtype1_idx", columns={"gradingtype_id"})})
 * @ORM\Entity
 */
class SubjectHasGradingtype
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

    /**
     * @var \Core\Entity\Gradingtype
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Core\Entity\Gradingtype")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="gradingtype_id", referencedColumnName="id")
     * })
     */
    private $gradingtype;


}

