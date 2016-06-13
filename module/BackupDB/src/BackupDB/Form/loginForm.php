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
class loginForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct('login');

        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'placeholder' => 'Username',
                'required' => "required"
            )
        ));

        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
                'class' => 'form-control',
                'placeholder' => 'Password',
                'required' => "required"
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'label' => 'Log In',
            'attributes' => [
                'id' => 'submitbutton',
                'class' => 'btn btn-primary'
            ],
        ));
    }

}
