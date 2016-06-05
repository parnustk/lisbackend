<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="StudentGrade",
 *     indexes={
 *         @ORM\Index(name="IDX_E2AC510BCB944F1A", columns={"student_id"}),
 *         @ORM\Index(name="IDX_E2AC510BEBCFFF9A", columns={"grade_choice_id"}),
 *         @ORM\Index(name="IDX_E2AC510B41807E1D", columns={"teacher_id"}),
 *         @ORM\Index(name="IDX_E2AC510BEA0B7FD9", columns={"independent_work_id"}),
 *         @ORM\Index(name="IDX_E2AC510BAFC2B591", columns={"module_id"}),
 *         @ORM\Index(name="IDX_E2AC510B9E7D1CC8", columns={"subject_round_id"}),
 *         @ORM\Index(name="IDX_E2AC510BA30922ED", columns={"contact_lesson_id"}),
 *         @ORM\Index(name="IDX_E2AC510BDE12AB56", columns={"created_by"}),
 *         @ORM\Index(name="IDX_E2AC510B16FE72E1", columns={"updated_by"}),
 *         @ORM\Index(name="studentgrade_index_trashed", columns={"trashed"})
 *     }
 * )
 */
class StudentGrade
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", length=8)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, options={"default":"NULL"})
     */
    private $notes;

    /**
     * @ORM\Column(type="integer", length=11, nullable=true, options={"default":"NULL"})
     */
    private $trashed;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $created_at;

    /**
     * @ORM\Column(type="date", nullable=true, options={"default":"NULL"})
     */
    private $updated_at;
}