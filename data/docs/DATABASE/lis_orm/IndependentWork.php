<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="IndependentWork",
 *     indexes={
 *         @ORM\Index(name="IDX_6E5124F99E7D1CC8", columns={"subject_round_id"}),
 *         @ORM\Index(name="IDX_6E5124F941807E1D", columns={"teacher_id"}),
 *         @ORM\Index(name="IDX_6E5124F9DE12AB56", columns={"created_by"}),
 *         @ORM\Index(name="IDX_6E5124F916FE72E1", columns={"updated_by"}),
 *         @ORM\Index(name="independentwork_index_trashed", columns={"trashed"}),
 *         @ORM\Index(name="independentworkduedate", columns={"duedate"})
 *     }
 * )
 */
class IndependentWork
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", length=8)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $duedate;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", length=11, nullable=false)
     */
    private $durationAK;

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