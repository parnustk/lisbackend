<?php

/*
 * GradeSubjectRound Controller
 */

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;

/**
 * Description of GradeSubjectRoundController
 *
 * @author Alar Aasa <alar@alaraasa.ee>
 */
class GradeSubjectRoundController extends AbstractBaseController
{
    /*
     * @var type
     */
    protected $service = 'gradesubjectround_service';
    
    /*
     * <h2>GET admin/GradeSubjectRound</h2>
     * <h3>URL Parameters</h3>
     * <code>limit(integer)
     * page(integer)</code>
     * 
     * @return JsonModel
     */
    public function getList()
    {
        return parent::getList();
    }
    
    
    /*
     * <h2>GET admin/GradeSubjectRound</h2>
     * <h3>URL Parameters</h3>
     * <code>id(integer)</code>
     * 
     * @param int $id
     * @return JsonModel
     */
    public function get($id)
    {
        return parent::get($id);
    }
    
    /*
     * <h2>POST admin/GradeSubjectRound</h2>
     * <h3>Body</h3>
     * <code>id(integer)
     * sudentgroupid(integer)</code>
     * 
     * @param array $data
     * @return JsonModel
     */
    public function create($data)
    {
        return parent::create($data);
    }
    
    /*
     * <h2>UPDATE admin/GradeSubjectRound</h2>
     * <h3>Body</h3>
     * <code>id(integer)
     * data(array)</code>
     * 
     * @param int $id
     * @return JsonModel
     */
    public function update($id, $data)
    {
        return parent::update($id,$data);
    }
    
    
    /*
     * <h2>DELETE admin/GradeSubjectRound</h2>
     * 
     * 
     * @param int $id
     * @return JsonModel
     */
    public function delete($id)
    {
        return parent::delete($id);
    }
}
