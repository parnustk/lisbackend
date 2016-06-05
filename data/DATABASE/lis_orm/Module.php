<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="Module",
 *     indexes={
 *         @ORM\Index(name="IDX_B88231E4A14BDC1", columns={"vocation_id"}),
 *         @ORM\Index(name="IDX_B88231E6E37B28A", columns={"module_type_id"}),
 *         @ORM\Index(name="IDX_B88231EDE12AB56", columns={"created_by"}),
 *         @ORM\Index(name="IDX_B88231E16FE72E1", columns={"updated_by"}),
 *         @ORM\Index(name="modulename", columns={"name"}),
 *         @ORM\Index(name="modulecode", columns={"moduleCode"}),
 *         @ORM\Index(name="moduleduration", columns={"duration"}),
 *         @ORM\Index(name="module_trashed", columns={"trashed"})
 *     }
 * )
 */
class Module
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
     * @ORM\Column(type="integer", length=11, nullable=false)
     */
    private $duration;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $moduleCode;

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