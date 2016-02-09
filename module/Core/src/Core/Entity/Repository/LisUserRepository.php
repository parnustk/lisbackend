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
     * 
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     * @return LisUser
     * @throws Exception
     */
    public function Create($data, $returnPartial = false, $extra = null)
    {
        $entity = new LisUser($this->getEntityManager());
    
        $data['password'] = (new Bcrypt)
                ->setCost($this->passwordCost)
                ->create($data['password']);

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

}
