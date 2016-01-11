<?php

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
     * @ORM\OneToMany(targetEntity="SubjectGradeChoice", mappedBy="studentGroup")
     * @Annotation\Exclude()
     */
    protected $subjectGradeChoice;

    /**
     * @ORM\OneToMany(targetEntity="Grade", mappedBy="gradeChoice")
     * @Annotation\Exclude()
     */
    protected $studentGrade;

    /**
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Annotation\Exclude()
     */
    protected $updatedBy;
    //ALT +INSERT

    protected $createdBy;

    /**
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Annotation\Exclude()
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Annotation\Exclude(
     */
    protected $updatedAt;

    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function refreshTimeStamps()
    {
        if($this->getCreatedAt() === null){
            $this->getCreateAt(new DateTime);
        }
        $this->getUpdatedAt(new DateTime);
    }

    /**
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Annotation\Exclude()
     */
    public function getSubjectGradeChoice() {
        return $this->subjectGradeChoice;
    }

    public function getUpdatedBy() {
        return $this->updatedBy;
    }

    public function getCreatedBy() {
        return $this->createdBy;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function setSubjectGradeChoice($subjectGradeChoice) {
        $this->subjectGradeChoice = $subjectGradeChoice;
        return $this;
    }

    public function setUpdatedBy($updatedBy) {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    public function setCreatedBy($createdBy) {
        $this->createdBy = $createdBy;
        return $this;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    protected $trashed;

    /**
     * 
     * @return type 
     */
    public function getTrashed() {
        return $this->trashed;
    }

    public function setTrashed($trashed) {
        $this->trashed = $trashed;
        return $this;
    }

    /**
     * 
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em = null) {
        parent::__construct($em);
    }

    public function getId() {
        return $this->id;
    }

    public function getSubjectRound() {
        return $this->subjectRound;
    }

    public function getName() {
        return $this->name;
    }

    public function getStudentGrade() {
        return $this->studentGrade;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setStudentGrade($studentGrade) {
        $this->studentGrade = $studentGrade;
        return $this;
    }

}
