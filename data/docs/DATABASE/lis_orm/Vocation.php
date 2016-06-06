<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="Vocation",
 *     indexes={
 *         @ORM\Index(name="IDX_4A93C67EDE12AB56", columns={"created_by"}),
 *         @ORM\Index(name="IDX_4A93C67E16FE72E1", columns={"updated_by"}),
 *         @ORM\Index(name="vocationname", columns={"name"}),
 *         @ORM\Index(name="vocationcode", columns={"vocationCode"}),
 *         @ORM\Index(name="vocation_index_trashed", columns={"trashed"})
 *     },
 *     uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_4A93C67E1DB10854", columns={"vocationCode"})}
 * )
 */
class Vocation
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
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $vocationCode;

    /**
     * @ORM\Column(type="integer", length=11, nullable=false)
     */
    private $durationEKAP;

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