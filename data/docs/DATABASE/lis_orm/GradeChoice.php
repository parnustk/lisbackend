<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="GradeChoice",
 *     indexes={
 *         @ORM\Index(name="IDX_D7BA4EC6DE12AB56", columns={"created_by"}),
 *         @ORM\Index(name="IDX_D7BA4EC616FE72E1", columns={"updated_by"}),
 *         @ORM\Index(name="gradechoice_listype", columns={"lisType"}),
 *         @ORM\Index(name="gradechoice_index_trashed", columns={"trashed"})
 *     }
 * )
 */
class GradeChoice
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $lisType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, options={"default":"NULL"})
     */
    private $description;

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