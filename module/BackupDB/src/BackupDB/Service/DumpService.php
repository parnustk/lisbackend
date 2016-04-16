<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */
/*
 * Plan A: Backups generate:
 * Table Names
 * Column Names
 * Relations/Foreign Keys
 * Data
 * 
 * Plan B:
 * Static structure.sql made manually in dev.
 * Backup only fetches data
 */

namespace BackupDB\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Doctrine\ORM\EntityManager;
use Exception;
use PDO;

define("_PATH_", "/home/marten/LIS_workspace/lisbackend/data/BackupDB_Dumps/");

/**
 * @author Marten Kähr <marten@kahr.ee>
 */
class DumpService implements ServiceManagerAwareInterface
{

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     *
     * @var EntityManager
     */
    protected $entityManager = null;

    /**
     * Retrieve service manager instance
     *
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * 
     * @param ServiceManager $serviceManager
     * @return \Core\Service\AbstractBaseService
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    /**
     * 
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * 
     * @param EntityManager $entityManager
     * @return \Core\Service\AbstractBaseService
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

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
                'mysql:host=localhost;' .
                ' dbname=lis;' . ' charset=utf8mb4', 'root', 'MgjsfF7'
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
    public function createDump($type)
    {
        $this->setUp();
        $this->setFilename($type);
        $dumpStructure = null;

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

//        for ($t = 0; $t < count($tables); $t++) { //Loop through all tables, append new data into output file with each loop      
        for ($t = 0; $t < 1; $t++) { //Alternate loop for debugging
            //Purpose: Prepare structure query statement
            $tableString = '`' . $tables[$t] . '`';
            $stmt = $this->db->prepare('SHOW CREATE TABLE ' . $tableString . ';');
            //Debugging lines:
            print_r($tables[$t] . "<br>");
            //Query table structure
            try {
                //This part adds table structure to dumpData
                $stmt->execute();
                $fetchData = $stmt->fetch();
                $dumpData = $fetchData[1]."; \n";
            } catch (PDOException $ex) {
                print_r($ex);
                die();
            }
            //Write structure to table
            file_put_contents(_PATH_ . $this->fileName, $dumpStructure, FILE_APPEND);
            
            $stmt = $this->db->prepare('SELECT id FROM ' . $tableString . ' WHERE 1;');
            $stmt->execute();
            $rowCount = count($stmt->fetchAll());
            $columnNames = null;
            for ($i = 0; $i < $rowCount+1; $i++) { //Write data from single table
                $fetchData = null;
                $columnCount = null;
                $dumpData = null;
                if ($i == 0) { //Begin backup INSERT statement
                    $stmt = $this->db->prepare("SELECT `COLUMN_NAME` 
                                                FROM `INFORMATION_SCHEMA`.`COLUMNS` 
                                                WHERE `TABLE_SCHEMA`= 'lis' 
                                                AND `TABLE_NAME`='" . $tables[$t] . "';");
                    $stmt->execute();
                    $fetchData = $stmt->fetchAll(); //fetchData is Column Names
                    $columnCount = count($fetchData);
                    $columnNames = array_column($fetchData, 'COLUMN_NAME');
                    $dumpData = "INSERT INTO " . $tableString . "(";
                    for ($c=0;$c<$columnCount+1;$c++) { //Append column names into statement
                        if ($c == $columnCount) { //Close column names, begin data
                            $dumpData .= ") \n VALUES";
                            break;
                        }
                        if ($c == 0) { //Append first column name into statement
                            $dumpData .= $columnNames[$c];
                        } else { //Append following column names into statement
                            $dumpData .= "," . $columnNames[$c];
                        }
                    }
                } elseif ($i == $rowCount) { //Add last data row; close statement; Breaks if table id column skips lines
                    $stmt = $this->db->prepare("SELECT * FROM " . $tableString .
                                               " WHERE id = " . $i . "; \n \n");
                    //Query data row
                    try {
                        $stmt->execute();
                        $fetchData = $stmt->fetchAll(); //fetchData is data row
                        $fetchData = $fetchData[0];
                    } catch (PDOException $ex) {
                        print_r($ex);
                        die();
                    }
                    for ($c = 0; $c < $columnCount; $c++) {
                        if ($c == 0) {
                            $dumpData .= "(".$fetchData[$columnNames[$c]];
                        } elseif ($c == $columnCount) { //Close data row value
                            $dumpData .= "); \n";
                        } else {
                            if (isset($fetchData[$columnNames[$c]])) {
                            $dumpData .= "," . $fetchData[$columnNames[$c]];
                            } else { $dumpData .= ",NULL"; }
                        }
                    }
                    
                } else { //Add regular data row.
                    $stmt = $this->db->prepare("SELECT * FROM " . $tableString .
                            " WHERE id = " . $i . ";");
                    //Query table data
                    try {
                        $stmt->execute();
                        $fetchData = $stmt->fetchAll(); //fetchData is data row
                        if (count($fetchData)!= 0) {
                        $fetchData = $fetchData[0];
                        } else {  }
                    } catch (PDOException $ex) {
                        print_r($ex);
                        die();
                    }
                    for ($c = 0; $c<$columnCount; $c++) {
                        if ($c == 0) {
                            $dumpData .= "(".$fetchData[$columnNames[$c]];
                        } elseif ($c == $columnCount) { //Close data row value
                            $dumpData .= "), \n";
                        } else {
                            if (isset($fetchData[$columnNames[$c]])) {
                            $dumpData .= "," . $fetchData[$columnNames[$c]];
                            } else { $dumpData .= ",NULL"; }
                        }
                    }
                    file_put_contents(_PATH_ . $this->fileName, $dumpData, FILE_APPEND);
                }
                //Write current pass to file
//                file_put_contents(_PATH_ . $this->fileName, $dumpData, FILE_APPEND);
            }
        }
        //Disabled for debugging above code
//        if ($type == 'manual') {
//            file_put_contents($this->fileName, $dumpData);
//            header("Content-disposition: attachment;filename=$filename");
//            readfile($this->filename);
//            return 'successM';
//        } else {
//            file_put_contents($this->fileName, $dumpData);
//            return 'successA';
//        }
    }

}
