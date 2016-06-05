<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="GradingType",
 *     indexes={
 *         @ORM\Index(name="IDX_739B38C9DE12AB56", columns={"created_by"}),
 *         @ORM\Index(name="IDX_739B38C916FE72E1", columns={"updated_by"}),
 *         @ORM\Index(name="name", columns={"name"}),
 *         @ORM\Index(name="gradingtype_index_trashed", columns={"trashed"})
 *     }
 * )
 */
class GradingType
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

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