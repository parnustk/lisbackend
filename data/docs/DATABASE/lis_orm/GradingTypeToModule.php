<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="GradingTypeToModule",
 *     indexes={
 *         @ORM\Index(name="IDX_444C5752AFC2B591", columns={"module_id"}),
 *         @ORM\Index(name="IDX_444C5752F54FA8CE", columns={"grading_type_id"})
 *     }
 * )
 */
class GradingTypeToModule
{
}