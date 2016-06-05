<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="GradingTypeToSubject",
 *     indexes={
 *         @ORM\Index(name="IDX_4B56CE2923EDC87", columns={"subject_id"}),
 *         @ORM\Index(name="IDX_4B56CE29F54FA8CE", columns={"grading_type_id"})
 *     }
 * )
 */
class GradingTypeToSubject
{
}