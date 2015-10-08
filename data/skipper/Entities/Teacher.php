<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     indexes={
 *         @ORM\Index(name="teachercode", columns={"code"}),
 *         @ORM\Index(name="teacherfirstname", columns={"firstName"}),
 *         @ORM\Index(name="teacherlastname", columns={"lastName"})
 *     }
 * )
 */
class Teacher
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
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
     * @ORM\Column(type="string", unique=true, length=255, nullable=false)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="SubjectRound", mappedBy="teacher")
     */
    private $subjectRound;
}