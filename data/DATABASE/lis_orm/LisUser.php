<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="LisUser",
 *     indexes={@ORM\Index(name="lisuser_index_trashed", columns={"trashed"})},
 *     uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_83ABA295E7927C74", columns={"email"})}
 * )
 */
class LisUser
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
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @ORM\Column(type="integer", length=11, nullable=false, options={"default":"'1'"})
     */
    private $state;

    /**
     * @ORM\Column(type="integer", length=11, nullable=true, options={"default":"NULL"})
     */
    private $trashed;
}