<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="TeacherToSubjectRound",
 *     indexes={
 *         @ORM\Index(name="IDX_9E62F5CF9E7D1CC8", columns={"subject_round_id"}),
 *         @ORM\Index(name="IDX_9E62F5CF41807E1D", columns={"teacher_id"})
 *     }
 * )
 */
class TeacherToSubjectRound
{
}