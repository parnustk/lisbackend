<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="StudentInGroups",
 *     indexes={
 *         @ORM\Index(name="IDX_DFC1C6E9CB944F1A", columns={"student_id"}),
 *         @ORM\Index(name="IDX_DFC1C6E94DDF95DC", columns={"student_group_id"}),
 *         @ORM\Index(name="IDX_DFC1C6E9DE12AB56", columns={"created_by"}),
 *         @ORM\Index(name="IDX_DFC1C6E916FE72E1", columns={"updated_by"}),
 *         @ORM\Index(name="studentingroups_index_trashed", columns={"trashed"}),
 *         @ORM\Index(name="studentingroups_index_status", columns={"status"})
 *     }
 * )
 */
class StudentInGroups
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", length=8)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", length=11, nullable=false, options={"default":"'1'"})
     */
    private $status;

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