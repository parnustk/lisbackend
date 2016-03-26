<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace BackupDB\Service;

use PDO;

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
     */
    protected $db;
    
    /**
     *
     * @var string
     */
    protected $fileName;
    
    /**
     * 
     */
    protected function setUp() //Should load values things from config later
    {
        $this->db = new PDO(
                            'mysql:host=localhost;'.
                            ' dbname=lis;'. ' charset=utf8mb4',
                            'root', 'MgjsfF7'
                           );
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    /**
     * 
     * @param string $type
     */
    protected function setFileName($type)
    {
        $this->fileName = 'LISBACKUP_' . $type . '_' . date('dmY') . '_' . date('His');
        return;
    }
    
    /**
     * 
     * @param string $type
     */
    public function createDump ($type)
    {
        $this->setUp();
        $this->setFilename($type);
        $dumpData = null;
        
        //TODO: Create SQL Dump
        $tables = [
            "Absence",
            "AbsenceReason",
            "Administrator",
            "ContactLesson",
            "GradeChoice",
            "GradingType",
            "IndependentWork",
            "LisUser",
            "Module",
            "ModuleType",
            "Rooms",
            "Student",
            "StudentGrade",
            "StudentGroup",
            "StudentInGroups",
            "Subject",
            "SubjectRound",
            "Teacher",
            "Vocation"
        ];
        for($t = 0;$t<count($tables);$t++){ //Loop through all tables, create temporary dumpfiles with mysql
            //TODO: pull data and structure from table into $queryData
            $stmt = $this->db->prepare("SELECT * INTO OUTFILE filename=? FROM table=?");
            $stmt->bindValue(1, "temp".$tables[$t].".sql", PDO::PARAM_STR);
            $stmt->bindValue(2, $tables[$t], PDO::PARAM_STR);
            try 
            { 
                $stmt->execute();
            } catch (PDOException $ex) 
            {
                print_r($ex); 
                die();
            }
        }
        
        for($t = 0;$t<count($tables);$t++) 
        {
            $fileData = null;
            $fileData = readfile("temp".$tables[t].".sql");
            $dumpData .= $fileData;
            unlink("temp".$tables[t].".sql");
            unset($fileData);
        }  
            
        if($type == 'manual')
        {
            file_put_contents($this->fileName, $dumpData);
            header("Content-disposition: attachment;filename=$filename");
            readfile($this->filename);
            return 'successM';
        } else 
        {
            file_put_contents($this->fileName, $dumpData);
            return 'successA';
        }
        
    }
}