<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace BackupDB\Service;

use DateTime;

/**
 * @author Marten Kähr <marten@kahr.ee>
 */
class DumpService
{
    /**
     *
     * @var type 
     */
    protected $config_params;
    
    /**
     *
     * @var string
     */
    protected $output_filename;
    
    protected function setFilename($type)
    {
        $output_filename = 'LISBACKUP_' . $type . '_' . date('dmY') . '_' . date('His');
    }
    
    public function createDump ($type)
    {
        setFilename($type);
        
        //TODO: Create SQL Dump
        
        if($type == 'manual')
        {
            //TODO: return dump file to controller
        } else 
        {
            //TODO: save file to server HD
        }
        
    }
}