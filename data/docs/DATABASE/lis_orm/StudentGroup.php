<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="StudentGroup",
 *     indexes={
 *         @ORM\Index(name="IDX_D636BBFA4A14BDC1", columns={"vocation_id"}),
 *         @ORM\Index(name="IDX_D636BBFADE12AB56", columns={"created_by"}),
 *         @ORM\Index(name="IDX_D636BBFA16FE72E1", columns={"updated_by"}),
 *         @ORM\Index(name="studentgroup_index_trashed", columns={"trashed"}),
 *         @ORM\Index(name="studentgroup_index_status", columns={"status"})
 *     }
 * )
 */
class StudentGroup
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
     * @ORM\Column(type="integer", length=11, nullable=false, options={"default":"'1'"})
     */
    private $status;

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