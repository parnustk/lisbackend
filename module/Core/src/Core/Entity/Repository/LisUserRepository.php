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
use Exception;
use Zend\Json\Json;
use Doctrine\ORM\Query;
use Zend\Crypt\Password\Bcrypt;

/**
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Juhan Kõks <juhankoks@gmail.com>
 */
class LisUserRepository extends EntityRepository
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
    
    /**
     * 
     */
    public function getLisUserList($params = null, $extra = null)
    {
        $dql = "SELECT
                    partial lisuser.{
                        id,
                        email,
                        password,
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
                FROM Core\Entity\LisUser lisuser
                
                ";    
    }

}
