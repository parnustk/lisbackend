<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace BackupDB\Form;

use Zend\Form\Form;

/**
 * Description of loginForm
 *
 * @author Marten Kähr
 */
class panelForm extends Form
{

    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('panel');

        //Upload form
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        //Upload elements
        $this->add(array(
            'name' => 'fileupload',
            'attributes' => array(
                'type' => 'file',
                'class' => 'btn btn-default'
            ),
            'options' => array(
                'label' => 'Upload Backup',
            ),
        ));
        $this->add(array(
            'name' => 'uploadsubmit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Upload Now',
                'id' => 'upsubmit',
                'class' => 'btn btn-primary'
            ),
        ));
        //Download elements
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'fileselect',
            'attributes' => array(
                'id' => 'filenames',
                'options' => array(
                    null
                ),
            ),
            'options' => array(
                'label' => 'Select File',
            ),
        ));
        $this->add(array(
            'name' => 'downloadsubmit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Download Selected',
                'id' => 'downsubmit',
                'class' => 'btn btn-primary'
            ),
        ));
        //Push elements
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'pushselect',
            'attributes' => array(
                'id' => 'pushnames',
                'options' => array(
                    null
                ),
            ),
            'options' => array(
                'label' => 'Select File',
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'pushcheckbox',
            'attributes' => array(
                'id' => 'pushconfirm',
                'options' => array(
                    null
                ),
            ),
            'options' => array(
                'label' => 'Confirm Push to DB?',
            ),
        ));
        $this->add(array(
            'name' => 'pushsubmit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Push Selected Backup to DB',
                'id' => 'dbpushsubmit',
                'class' => 'btn btn-danger'
            ),
        ));
        $this->add(array(
            'name' => 'logoutsubmit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Logout',
                'id' => 'logoutsubmit',
                'class' => 'btn btn-primary'
            ),
        ));
        $this->add(array(
            'name' => 'createsubmit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Create Backup on Server',
                'id' => 'createsubmit',
                'class' => 'btn btn-primary',
            ),
        ));
    }

}
