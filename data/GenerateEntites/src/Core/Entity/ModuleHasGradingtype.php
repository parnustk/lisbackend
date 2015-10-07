<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModuleHasGradingtype
 *
 * @ORM\Table(name="module_has_gradingtype", indexes={@ORM\Index(name="fk_module_has_grading_type_module1_idx", columns={"module_id"}), @ORM\Index(name="fk_module_has_grading_type_grading_type1_idx", columns={"grading_type_id"})})
 * @ORM\Entity
 */
class ModuleHasGradingtype
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var \Core\Entity\Module
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Core\Entity\Module")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="module_id", referencedColumnName="id")
     * })
     */
    private $module;

    /**
     * @var \Core\Entity\Gradingtype
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Core\Entity\Gradingtype")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="grading_type_id", referencedColumnName="id")
     * })
     */
    private $gradingType;


}

