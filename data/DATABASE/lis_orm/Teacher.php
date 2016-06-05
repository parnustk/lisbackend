<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="Teacher",
 *     indexes={
 *         @ORM\Index(name="IDX_7F4B9F49DE12AB56", columns={"created_by"}),
 *         @ORM\Index(name="IDX_7F4B9F4916FE72E1", columns={"updated_by"}),
 *         @ORM\Index(name="teachercode", columns={"personalCode"}),
 *         @ORM\Index(name="teacherfirstname", columns={"firstName"}),
 *         @ORM\Index(name="teacherlastname", columns={"lastName"}),
 *         @ORM\Index(name="teachertrashed", columns={"trashed"})
 *     },
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="UNIQ_7F4B9F49FEC554F2", columns={"personalCode"}),
 *         @ORM\UniqueConstraint(name="UNIQ_7F4B9F4963918838", columns={"lis_user_id"})
 *     }
 * )
 */
class Teacher
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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $personalCode;

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