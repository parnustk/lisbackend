<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="Rooms",
 *     indexes={
 *         @ORM\Index(name="IDX_BD603592DE12AB56", columns={"created_by"}),
 *         @ORM\Index(name="IDX_BD60359216FE72E1", columns={"updated_by"}),
 *         @ORM\Index(name="roomname", columns={"name"}),
 *         @ORM\Index(name="room_index_trashed", columns={"trashed"})
 *     }
 * )
 */
class Rooms
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