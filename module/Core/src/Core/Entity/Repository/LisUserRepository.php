<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace Core\Entity\Repository;

use Core\Entity\LisUser;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Paginator\Paginator;
use Exception;
use Zend\Json\Json;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Query;
use Zend\Crypt\Password\Bcrypt;

/**
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Juhan Kõks <juhankoks@gmail.com>
 */
class LisUserRepository extends AbstractBaseRepository
{

    /**
     * Password Cost
     *
     * The number represents the base-2 logarithm of the iteration count used for
     * hashing. Default is 14 (about 10 hashes per second on an i5).
     *
     * Accepted values: integer between 4 and 31
     * @var type 
     */
    private $passwordCost = 4;
    
    public $baseAlias = 'lisUser';
    
    public $baseEntity = 'Core\Entity\LisUser';

    /**
     * To hash function
     * 
     * @param string $password plain password
     * @return string hash
     */
    public function passwordToHash($password)
    {
        if (empty($password)) {
            throw new Exception('NO_PASSWORD');
        }
        return (new Bcrypt)
                        ->setCost($this->passwordCost)
                        ->create($password);
    }

    public function checkAdministratorUserExists($email, $password)
    {
        try {
            if (empty($email)) {
                throw new Exception('NO_EMAIL');
            }
        } catch (Exception $e) {
            return $e;
        }
        try {
            if (empty($password)) {
                throw new Exception('NO_PASSWORD');
            }
        } catch (Exception $e) {
            return $e;
        }
        $validator = new \Zend\Validator\EmailAddress();
        if ($validator->isValid($email)) {
            // email appears to be valid
        } else {
            // email is invalid; print the reasons
            foreach ($validator->getMessages() as $message) {
                echo "$message\n";
            }
        }
    }

    /**
     * 
     * @param array $data
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return LisUser
     * @throws Exception
     */
    public function Create($data, $returnPartial = false, $extra = null)
    {
        if (count($data) < 1) {
            throw new Exception('NO_DATA');
        }
        $entity = new LisUser($this->getEntityManager());

        $data['password'] = $this->passwordToHash($data['password']);

        $entity->hydrate($data);

        if (!$entity->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);

        if ($returnPartial) {

            $dql = "SELECT 
                        partial lisuser.{
                            id,
                            email,
                            password
                        }
                    FROM Core\Entity\LisUser lisuser
                    WHERE lisuser.id = " . $entity->getId();

            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
            $r = $q->getSingleResult(Query::HYDRATE_ARRAY);
            return $r;
        }

        return $entity;
    }
    
    
    protected function dqlWhereInner($dql, $params)
    {
        $firstCycle = true;
        foreach ($params['where'] as $key => $value) {
            if (!$firstCycle) {
                $dql .= ' AND';
            } else {
                $dql .= " WHERE";
                $firstCycle = false;
            }

            if (is_object($value)) {
                $v = $value->id;
                $dql .= " $this->baseAlias.$key=$v ";
            } else if (is_array($value)) { //needs to be made using unit tests
                $firstCycleI = true;
                $dql .= ' (';
                foreach ($value as $ki => $vi) {
                    if (!$firstCycleI) {
                        $dql .= ' OR ';
                    } else {
                        $firstCycleI = false;
                    }

                    $vInner = $vi->id;
                    $dql .= " $key.id=$vInner ";
                }
                $dql .= ') ';
            } else {
                $dql .= " $this->baseAlias.$key='$value' ";
            }
        }
        //throw new Exception($dql);//debug dql where part
        return $dql;
    }
    
    
    protected function dqlWhere($params, $extra = null)
    {
        $dql = '';

        if (!!$params['where']) {//if where is not null
            $dql = $this->dqlWhereInner($dql, $params);
        } else {//default WHERE has trashed IS NULL for now nothing else
            $dql .= " WHERE ($this->baseAlias.trashed IS NULL OR $this->baseAlias.trashed=0)";
        }
        if (!!$extra) {
            //TODO
        }
        //throw new Exception($dql);//debug dql where part
        return $dql;
    }
    
    /**
     * 
     * @param type $params
     * @param type $extra
     * @return Paginator
     */
    private function SuperAdminGetList($params = null, $extra = null)
    {
        $dql = "SELECT
                    partial lisUser.{
                        id,
                        email,
                        state,
                        trashed
                    },
                    partial administrator.{
                        id,
                        name,
                        email,
                        personalCode
                    },
                    partial teacher.{
                        id,
                        name,
                        email,
                        personalCode
                    },
                    partial student.{
                        id,
                        name,
                        email,
                        personalCode
                    }
                FROM Core\Entity\LisUser lisUser
                
                LEFT JOIN lisUser.administrator administrator
                LEFT JOIN lisUser.teacher teacher
                LEFT JOIN lisUser.student student
                ";   
        $dql .= $this->dqlWhere($params, $extra);
        
        $q = $this->getEntityManager()->createQuery($dql);
        $q->setHydrationMode(Query::HYDRATE_ARRAY);
        return new Paginator(
                new DoctrinePaginator(new ORMPaginator($q))
        );
    }
    
    /**
     * 
     * @param type $params
     * @param type $extra
     * @return string
     */
    public function GetList($params = null, $extra = null)
    {
        if(!$extra){
            return 'You must be admin';
        } else if ($extra->lisRole === 'administrator'){
            return $this->SuperAdminGetList($params, $extra);
        } else {
            return 'You have no permission';
        }
    }
    
    
    private function SuperAdminUpdate($entity, $data, $returnPartial = false, $extra = null)
    {
        if (count($data) < 1) {
            throw new Exception('NO_DATA');
        }
        
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);
        
        $dql = "UPDATE Core\Entity\LisUser lisUser";
        
        //add to query depending on what is wanted to be updated
        if ((!empty($data['email'])) && (!empty($data['password']))){
            $dql .= " SET lisUser.email = :email,
                    lisUser.password = :password";
            $data['password'] = $this->passwordToHash($data['password']);
        } else if (!empty($data['email'])){
            $dql .= " SET lisUser.email = :email";
        } else if (!empty($data['password'])) {
            $dql .= " SET lisUser.password = :password";
            $data['password'] = $this->passwordToHash($data['password']);
        }
        $dql .= " WHERE lisUser.id = :id";
        $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
        
        // if data send, set the parameters
        if (!empty($data['email'])){
            $q->setParameter('email', $data['email'], Type::STRING);
        }
        if (!empty($data['password'])) {
            $q->setParameter('password', $data['password'], Type::STRING);
        }
        
        $q->setParameter('id', $entity->getId(), Type::INTEGER);
        
        return $q->getSingleResult($hydrateMethod = Query::HYDRATE_ARRAY);
    }
    
    
//    public function Update($id, $data, $returnPartial = false, $extra = null)
//    {
//        $entity = $this->find($id);
//        if (!$entity) {
//            throw new Exception('NOT_FOUND_ENTITY');
//        }
//        
//        if (!$extra) {
//            return 'You must be admin';
//        } else if ($extra->lisRole === 'administrator') {
//            return $this->SuperAdminUpdate($entity, $data, $returnPartial, $extra);
//        } else {
//            return 'You have no permission';
//        }
//    }
    protected function dqlStart()
    {
        $dql = "SELECT
                    partial $this->baseAlias.{
                     id,
                        email,
                        state,
                        trashed
                }
                FROM $this->baseEntity $this->baseAlias";
        return $dql;
    }

    /**
     * 
     * @return string
     */
    protected function dqlStudentStart()
    {
        $dql = "SELECT
                    partial $this->baseAlias.{
                     id,
                        email,
                        state,
                        trashed
                }
                FROM $this->baseEntity $this->baseAlias";

        return $dql;
    }

    /**
     * 
     * @return string
     */
    protected function dqlTeacherStart()
    {
        $dql = "SELECT
                    partial $this->baseAlias.{
                     id,
                        email,
                        state,
                        trashed
                }
                FROM $this->baseEntity $this->baseAlias";

        return $dql;
    }

    /**
     * 
     * @return string
     */
    protected function dqlAdministratorStart()
    {
        $dql = "SELECT
                    partial $this->baseAlias.{
                     id,
                        email,
                        state,
                        trashed
                }
                FROM $this->baseEntity $this->baseAlias";

        return $dql;
    }
    
    public function Update($id, $data, $returnPartial = false, $extra = null)
    {
        $entity = $this->find($id);
        if (!$entity) {
            throw new Exception('NOT_FOUND_ENTITY');
        }
        if (!$extra) {
            return $this->defaultUpdate($entity, $data, $returnPartial);
        } else if ($extra->lisRole === 'student') {
            return $this->studentUpdate($entity, $data, $returnPartial, $extra);
        } else if ($extra->lisRole === 'teacher') {
            return $this->teacherUpdate($entity, $data, $returnPartial, $extra);
        } else if ($extra->lisRole === 'administrator') {
            return $this->SuperAdminUpdate($entity, $data, $returnPartial, $extra);
        }
    }

    /**
     * 
     * @param type $entity
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     * @return type
     */
    private function defaultUpdate($entity, $data, $returnPartial = false, $extra = null)
    {
        $entityValidated = $this->validateEntity(
                $entity, $data
        );
        //IF required MANY TO MANY validate manually
        return $this->singleResult($entityValidated, $returnPartial, $extra);
    }

    /**
     * 
     * @param type $entity
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     * @return type
     * @throws Exception
     */
    private function studentUpdate($entity, $data, $returnPartial = false, $extra = null)
    {
        //set user related data
        $data['createdBy'] = null;
        $data['updatedBy'] = $extra->lisUser->getId();
        return $this->defaultUpdate($entity, $data, $returnPartial, $extra);
    }

    /**
     * 
     * @param type $entity
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     * @return type
     */
    private function teacherUpdate($entity, $data, $returnPartial = false, $extra = null)
    {
        //set user related data
        $data['createdBy'] = null;
        $data['updatedBy'] = $extra->lisUser->getId();
        return $this->defaultUpdate($entity, $data, $returnPartial, $extra);
    }

    /**
     * 
     * @param type $entity
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     * @return type
     */
    private function administratorUpdate($entity, $data, $returnPartial = false, $extra = null)
    {
        //set user related data
        $data['createdBy'] = null;
        $data['updatedBy'] = $extra->lisUser->getId();
        return $this->defaultUpdate($entity, $data, $returnPartial, $extra);
    }
    
    
    private function defaultDelete($entity)
    {
        $id = $entity->getId();
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
        return $id;
    }
    
    private function administratorDelete($entity, $extra = null)
    {
        return $this->defaultDelete($entity, $extra);
    }
    
    
    public function Delete($id, $extra = null)
    {
        $entity = $this->find($id);

        if (!$entity) {
            throw new Exception('NOT_FOUND_ENTITY');
        } else if (!$entity->getTrashed()) {
            throw new Exception("NOT_TRASHED");
        }

        if (!$extra) {
            return $this->defaultDelete($entity);
        } else if ($extra->lisRole === 'administrator') {
            return $this->administratorDelete($entity, $extra);
        }
    }

    /**
     * 
     * @param int $id
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return mixed
     */
    public function Get($id, $returnPartial = false, $extra = null)
    {
        $entity = $this->find($id);
        if (!$entity) {
            throw new Exception('NOT_FOUND_ENTITY');
        }
        if (!$extra) {
            return $this->defaultGet($id, $returnPartial, $extra);
        } else if ($extra->lisRole === 'student') {
            return $this->studentGet($entity, $returnPartial, $extra);
        } else if ($extra->lisRole === 'teacher') {
            return $this->teacherGet($entity, $returnPartial, $extra);
        } else if ($extra->lisRole === 'administrator') {
            return $this->administratorGet($entity, $returnPartial, $extra);
        }
    }

    /**
     * 
     * @param type $id
     * @param type $returnPartial
     * @param type $extra
     * @return type
     */
    private function defaultGet($id, $returnPartial = false, $extra = null)
    {
        if ($returnPartial) {
            return $this->singlePartialById($id, $extra);
        }
        return $this->find($id);
    }

    /**
     * 
     * @param type $entity
     * @param type $returnPartial
     * @param type $extra
     * 
     * @return array
     */
    private function studentGet($entity, $returnPartial = false, $extra = null)
    {
        return $this->defaultGet($entity->getId(), $returnPartial, $extra);
    }

    /**
     * 
     * @param type $entity
     * @param type $returnPartial
     * @param type $extra
     * @return type
     */
    private function teacherGet($entity, $returnPartial = false, $extra = null)
    {
        return $this->defaultGet($entity->getId(), $returnPartial, $extra);
    }

    /**
     * 
     * @param type $entity
     * @param type $returnPartial
     * @param type $extra
     * @return type
     */
    private function administratorGet($entity, $returnPartial = false, $extra = null)
    {
        return $this->defaultGet($entity->getId(), $returnPartial, $extra);
    }
}
