<?php
/**
 * LIS development
 * Rest API Entity
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 LIS dev team
 * @license   https://opensource.org/licenses/MIT MIT License
 * @author Arnold Tserepov <tserepov@gmail.com>
 */
namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Core\Utils\EntityValidation;
use Doctrine\ORM\EntityManager;
use DateTime;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\GradeChoiceRepository")
 * @ORM\Table(indexes={@ORM\Index(name="gradechoice_index_trashed", columns={"trashed"})}
 * @ORM\HasLifecycleCallbacks
 */
class GradeChoice extends EntityValidation {

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Exclude()
     */
    protected $id;

    /**
     * @ORM\Column(type="string",length=255, nullable=false)
     * @Annotation\Required({"required":"true"})
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="Vocation", inversedBy="gradeChoice")
     * @ORM\JoinColumn(name="vocation_id", referencedColumnName="id", nullable=false, unique=true, onDelete="RESTRICT")
     * @Annotation\Required({"required":"true"})
     */
     protected $GradeChoice;
     /**
     * @ORM\Column(type= "integer", nullable= true)
     * @Annotation\Exclude()
     */
    protected $subjectRound;

    /**
     * @ORM\OneToMany(targetEntity="Student", mappedBy="gradeChoice")
     * @Annotation\Exclude()
     */
    protected $student;

    /**
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Annotation\Exclude()
     */
    protected $getTrashed;

   /**
     * 
     * @return type
     */
    public function getTrashed()
    {
        return $this->trashed;
    }
    /**
     * 
     * @param type $trashed
     * @return \Core\Entity\AbsenceReason
     */
    public function setTrashed($trashed)
    {
        $this->trashed = $trashed;
        return $this;
    }

    protected $createdBy;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="LisUser")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id", nullable=true)
     */
    protected $updatedBy;

    /**
     *
     * @ORM\Column(type="datetime", name="created_at", nullable=false)
     * @Annotation\Exclude()
     */
    protected $createdAt;

    /**
     *
     * @ORM\Column(type="datetime", name="updated_at", nullable=false)
     * @Annotation\Exclude()
     */
    protected $updatedAt;

    /**
     * 
     * @return type 
     */

    /**
     * 
     * @param EntityManager $em
     */
     public function __construct(EntityManager $em = null)
    {
        parent::__construct($em);
    }
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getGradeChoice()
    {
        return $this->gradechoice;
    }
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    public function setGradeChoice($gradechoice)
    {
        $this->gradechoice = $gradechoice;
        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function refreshTimeStamps() {
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new DateTime);
        }
        $this->setUpdatedAt(new DateTime);
    }

}
