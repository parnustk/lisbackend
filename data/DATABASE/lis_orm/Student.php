<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="Student",
 *     indexes={
 *         @ORM\Index(name="IDX_789E96AFDE12AB56", columns={"created_by"}),
 *         @ORM\Index(name="IDX_789E96AF16FE72E1", columns={"updated_by"}),
 *         @ORM\Index(name="studentcode", columns={"personalCode"}),
 *         @ORM\Index(name="studentfirstname", columns={"firstName"}),
 *         @ORM\Index(name="studentlastname", columns={"lastName"}),
 *         @ORM\Index(name="studentname", columns={"name"})
 *     },
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="UNIQ_789E96AFFEC554F2", columns={"personalCode"}),
 *         @ORM\UniqueConstraint(name="UNIQ_789E96AF63918838", columns={"lis_user_id"})
 *     }
 * )
 */
class Student
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