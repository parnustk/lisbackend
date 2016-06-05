<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="Subject",
 *     indexes={
 *         @ORM\Index(name="IDX_347307E6AFC2B591", columns={"module_id"}),
 *         @ORM\Index(name="IDX_347307E6DE12AB56", columns={"created_by"}),
 *         @ORM\Index(name="IDX_347307E616FE72E1", columns={"updated_by"}),
 *         @ORM\Index(name="subjectname", columns={"name"}),
 *         @ORM\Index(name="subjectcode", columns={"subjectCode"}),
 *         @ORM\Index(name="subject_trashed", columns={"trashed"}),
 *         @ORM\Index(name="subject_durationAllAK", columns={"durationAllAK"}),
 *         @ORM\Index(name="subject_durationContactAK", columns={"durationContactAK"}),
 *         @ORM\Index(name="subject_durationIndependentAK", columns={"durationIndependentAK"})
 *     }
 * )
 */
class Subject
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
    private $subjectCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", length=11, nullable=false)
     */
    private $durationAllAK;

    /**
     * @ORM\Column(type="integer", length=11, nullable=false)
     */
    private $durationContactAK;

    /**
     * @ORM\Column(type="integer", length=11, nullable=false)
     */
    private $durationIndependentAK;

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