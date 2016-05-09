<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */
/*
 * Dump create logic done.
 * TODO: Return dump list for controller
 * TODO: Push selected dump to db
 */

namespace BackupDB\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Doctrine\ORM\EntityManager;
use Exception;
use PDO;

define("_PATH_", "data/BackupDB_Dumps/");

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
     * @var string
     */
    protected $dumpData;
    protected $tables = [
        "Absence",
        "AbsenceReason",
        "Administrator",
        "ContactLesson",
        "GradeChoice",
        "GradingType",
        "GradingTypeToModule",
        "GradingTypeToSubject",
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
        "TeacherToSubjectRound",
        "Vocation"
    ];

    /**
     *
     * @var int
     */
    protected $columnCount = null;

    /**
     * 
     * @var array 
     */
    protected $columnNames = array();

    /**
     * 
     */
    protected function setUp()
    {
        $data   = include 'config/autoload/backupdb.local.php';
        
        $host = $data['backupdb']['connection']['params']['host'];
        $dbname = $data['backupdb']['connection']['params']['dbname'];
        $uname = $data['backupdb']['connection']['params']['user'];
        $dbpwd = $data['backupdb']['connection']['params']['password'];

        $this->db = new PDO(
                'mysql:host=' . $host .
                '; dbname=' . $dbname . '; charset=utf8mb4', $uname, $dbpwd
        );
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function destructPDO() //Close PDO connection
    {
        try {
            $this->db = null;
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
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
        $this->setUp(); //Open DB connection
        $this->setFilename($type); //Set filename of backup file
        $this->dumpData = "SET FOREIGN_KEY_CHECKS=0; \n"; //Disables foreign key checks when restoring backup
        file_put_contents(_PATH_ . $this->fileName, $this->dumpData, FILE_APPEND);
        $this->dumpData = null;

        for ($t = 0; $t < count($this->tables); $t++) { //Loop through all tables, append new data into output file with each loop
            //Prepare structure query statement
            $stmt1 = $this->db->prepare('SHOW CREATE TABLE `' . $this->tables[$t] . '`;');

            //Query table structure
            try {
                $stmt1->execute();
                $fetchData = $stmt1->fetch();
                $this->dumpData = $fetchData[1] . "; \n";
            } catch (PDOException $ex) {
                print_r($ex);
                die();
            }
            //Write table structure to dumpfile
            file_put_contents(_PATH_ . $this->fileName, $this->dumpData, FILE_APPEND);
            $this->dumpData = null;

            //Count data rows of table
            $stmt2 = $this->db->prepare('SELECT * FROM `' . $this->tables[$t] . '` WHERE 1;');
            $stmt2->execute();
            $rowCount = count($stmt2->fetchAll());
            if ($rowCount == 0) { //Ends loop early if table contains no data
                continue;
            }
            for ($i = 0; $i < $rowCount; $i++) { //Write data from single table
                $fetchData = null;
                $this->dumpData = null;
                if ($i == 0) { //Begin backup INSERT statement
                    $this->dumpTableBegin($t);
                } else {
                    
                }
                if ($i == $rowCount - 1) { //Add last data row
                    $stmt = $this->db->prepare("SELECT * FROM `" . $this->tables[$t] .
                            "` LIMIT " . $i . ",1;");
                    //Query data row
                    try {
                        print_r("Fetch " . $this->tables[$t] . " row " . $i);
                        $stmt->execute();
                        $fetchData = $stmt->fetchAll(); //fetchData is data row
                        $fetchData = $fetchData[0];
                    } catch (PDOException $ex) {
                        print_r($ex);
                        die();
                    }
                    $this->dumpTableRow($fetchData, true);
                } else { //Add regular data row.
                    $stmt = $this->db->prepare("SELECT * FROM `" . $this->tables[$t] .
                            "` LIMIT " . $i . ",1;");
                    //Query data row
                    try {
                        $stmt->execute();
                        $fetchData = $stmt->fetchAll(); //fetchData is data row
                        $fetchData = $fetchData[0];
                    } catch (PDOException $ex) {
                        print_r($ex);
                        die();
                    }
                    $this->dumpTableRow($fetchData, false);
                }
                //Write current pass to file
                file_put_contents(_PATH_ . $this->fileName, $this->dumpData, FILE_APPEND);
            }
        }
        $this->destructPDO(); //Close DB connection
        $this->dumpData = "SET FOREIGN_KEY_CHECKS=1;"; //Re-enables foreign key checks when db has been restored from backup file
        file_put_contents(_PATH_ . $this->fileName, $this->dumpData, FILE_APPEND);
        print_r("Created dumpfile " . $this->fileName);
//        if ($type == 'manual') {
//            header("Content-disposition: attachment;filename=$this->filename");
//            file_get_contents($this->filename);
//            return 'successM';
//        } else {
//            return 'successA';
//        }
    }

    /**
     * Counts number of columns in table and put into $columnCount
     * Lists column names in array $columnNames
     * Appends the beginning of a table's INSERT INTO statement to $dumpData
     * 
     * @param type $tableIndex
     */
    protected function dumpTableBegin($tableIndex)
    {
        $stmt = $this->db->prepare("SELECT `COLUMN_NAME` 
                                    FROM `INFORMATION_SCHEMA`.`COLUMNS` 
                                    WHERE `TABLE_SCHEMA`= 'lis' 
                                    AND `TABLE_NAME`='" . $this->tables[$tableIndex] . "';");
        $stmt->execute();
        $fetchData = $stmt->fetchAll(); //fetchData is Column Names
        $this->columnCount = count($fetchData);
        $this->columnNames = array_column($fetchData, 'COLUMN_NAME');
        $this->dumpData = "INSERT INTO `" . $this->tables[$tableIndex] . "`(";
        for ($c = 0; $c <= $this->columnCount; $c++) { //Append column names into statement
            if ($c == $this->columnCount) { //Close column names
                $this->dumpData .= ") \n VALUES";
                break;
            }
            if ($c == 0) { //Append first column name into statement
                $this->dumpData .= $this->columnNames[$c];
            } else { //Append following column names into statement
                $this->dumpData .= "," . $this->columnNames[$c];
            }
        }
    }

    /**
     * Parses and appends single row of data values to $dumpData
     * 
     * @param int $tableIndex
     * @param int $id
     * @param bool $lastRow
     * @param obj $data
     */
    protected function dumpTableRow($data, $lastRow)
    {
        if (!$lastRow) {
            for ($c = 0; $c <= $this->columnCount; $c++) {
                if ($c == 0) {
                    $this->dumpData .= "(" . $this->sqlStringParse($data[$this->columnNames[$c]]);
                } elseif ($c == $this->columnCount) { //Close data row value
                    $this->dumpData .= "), \n";
                } else {
                    if (isset($data[$this->columnNames[$c]])) {
                        $this->dumpData .= "," . $this->sqlStringParse($data[$this->columnNames[$c]]);
                    } else {
                        $this->dumpData .= ",NULL";
                    }
                }
            }
        } else {
            for ($c = 0; $c <= $this->columnCount; $c++) {
                if ($c == 0) {
                    $this->dumpData .= "(" . $this->sqlStringParse($data[$this->columnNames[$c]]);
                } elseif ($c == $this->columnCount) { //Close data row value
                    $this->dumpData .= "); \n";
                } else {
                    if (isset($data[$this->columnNames[$c]])) {
                        $this->dumpData .= "," . $this->sqlStringParse($data[$this->columnNames[$c]]);
                    } else {
                        $this->dumpData .= ",NULL";
                    }
                }
            }
        }
    }

    /**
     * Adds SQL quotes to input string $var, if $var is a string
     * 
     * @param int OR string $var
     * @return int OR string
     */
    protected function sqlStringParse($var)
    {
        if (is_numeric($var)) {
            $temp = (int) $var;
        } else {
            $temp = "'" . $var . "'";
        }
        return $temp;
    }

    /**
     * Pushes an sql dump to server. Optionally clears existing data and structures.
     * 
     * @param string $filename
     * @param bool $clearTable
     */
    public function pushDump($filename, $clearTable)
    {
        $this->setUp();
// Disabled for now, loop execute causes race conditions with db connection.
//        if ($clearTable) {
//            $clearStmt = $this->db->prepare(
//                    "SET FOREIGN_KEY_CHECKS = 0;"
//                    . "DROP TABLE *;"
//                    . "SET FOREIGN_KEY_CHECKS = 1;");
//            try {
//                $clearStmt->execute();
//            } catch (PDOException $ex) {
//                print_r($ex);
//                die();
//            }
//        }

        $pushStatement = $this->db->prepare(file_get_contents(_PATH_ . $filename));
        try {
            $pushStatement->execute();
        } catch (PDOException $ex) {
            print_r($ex);
            die();
        }
    }

}
