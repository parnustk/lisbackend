<?php

namespace Core\Controller;

use Zend\View\Model\JsonModel;
use Exception;
use Zend\Json\Json;
use Core\Controller\AbstractBaseController;

/**
 * @author sander
 */
class SampleController extends AbstractBaseController
{

    /**
     *
     * @param  mixed $data
     * @return mixed
     */
    public function create($data)
    {
        $sampleService = $this
                ->getServiceLocator()
                ->get('sample_service');
        $r = $sampleService->Create($data);
        return new JsonModel($r);
    }

    /**
     * Return list of resources
     *
     * @return mixed
     */
    public function getList()
    {
        try {
            $sampleService = $this
                    ->getServiceLocator()
                    ->get('sample_service');

            $r = $sampleService->GetList();

            return new JsonModel([
                'success' => true,
                'data' => $r
            ]);
        } catch (\Exception $exc) {
            return new JsonModel([
                'success' => false,
                'message' => $exc->getMessage()
            ]);
        }
    }

//    NOT TESTED YET
//    /**
//     * Return single resource
//     *
//     * @param  mixed $id
//     * @return mixed
//     */
//    public function get($id)
//    {
//        try {
//            $em = $this
//                    ->getServiceLocator()
//                    ->get('Doctrine\ORM\EntityManager');
//
//            $sample = new \Core\Entity\Sample($em);
//
//            $sample->setName('tere maailm');
//
//            if (!$sample->validate()) {
//                throw new Exception(\Zend\Json\Json::encode($sample->getMessages(), true));
//            }
//            return new JsonModel([
//                'success' => true,
//                'data' => []
//            ]);
//        } catch (\Exception $exc) {
//            return new JsonModel([
//                'success' => false,
//                'message' => $exc->getMessage()
//            ]);
//        }
//
//        return new JsonModel([$id]);
//    }
//
//    /**
//     * Update an existing resource
//     *
//     * @param  mixed $id
//     * @param  mixed $data
//     * @return mixed
//     */
    public function update($id, $data)
    {
        return new JsonModel([$id => $data]);
    }

//
//    /**
//     * Delete an existing resource
//     *
//     * @param  mixed $id
//     * @return mixed
//     */
//    public function delete($id)
//    {
//        return new JsonModel([$id]);
//    }
}
