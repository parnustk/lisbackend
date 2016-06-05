<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="ContactLesson",
 *     indexes={
 *         @ORM\Index(name="IDX_EBB4C6A38E2368AB", columns={"rooms_id"}),
 *         @ORM\Index(name="IDX_EBB4C6A39E7D1CC8", columns={"subject_round_id"}),
 *         @ORM\Index(name="IDX_EBB4C6A34DDF95DC", columns={"student_group_id"}),
 *         @ORM\Index(name="IDX_EBB4C6A3AFC2B591", columns={"module_id"}),
 *         @ORM\Index(name="IDX_EBB4C6A34A14BDC1", columns={"vocation_id"}),
 *         @ORM\Index(name="IDX_EBB4C6A341807E1D", columns={"teacher_id"}),
 *         @ORM\Index(name="IDX_EBB4C6A3DE12AB56", columns={"created_by"}),
 *         @ORM\Index(name="IDX_EBB4C6A316FE72E1", columns={"updated_by"}),
 *         @ORM\Index(name="contactlesson_index_lessondate", columns={"lessonDate"}),
 *         @ORM\Index(name="contactlesson_trashed", columns={"trashed"}),
 *         @ORM\Index(name="contactlesson_description", columns={"description"}),
 *         @ORM\Index(name="contactlesson_name", columns={"name"}),
 *         @ORM\Index(name="contactlesson_sequenceNr", columns={"sequenceNr"})
 *     }
 * )
 */
class ContactLesson
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", length=8)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $lessonDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, options={"default":"NULL"})
     */
    private $description;

    /**
     * @ORM\Column(type="integer", length=11, nullable=false)
     */
    private $sequenceNr;

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