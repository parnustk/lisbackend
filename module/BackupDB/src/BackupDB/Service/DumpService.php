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
use Zend\Filter\File\RenameUpload;
use Doctrine\ORM\EntityManager;
use Exception;
use PDO;
use Zend\Authentication\Storage;
use Zend\Session\Container as SessionContainer;

define("_PATH_", "data/BackupDB_Dumps/");

/**
 * @author Marten Kähr <marten@kahr.ee>
 */
class DumpService implements ServiceManagerAwareInterface, Storage\StorageInterface
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
        $data = include 'config/autoload/backupdb.local.php';

        $host = $data['backupdb']['connection']['params']['host'];
        $dbname = $data['backupdb']['connection']['params']['dbname'];
        $uname = $data['backupdb']['connection']['params']['user'];
        $dbpwd = $data['backupdb']['connection']['params']['pwd'];

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
    public function createDump()
    {
        $this->setUp(); //Open DB connection
        $this->setFilename('server'); //Set filename of backup file
        $this->dumpData = "SET FOREIGN_KEY_CHECKS=0; \n"; //Disables foreign key checks when restoring backup
        file_put_contents(_PATH_ . $this->fileName, $this->dumpData, FILE_APPEND);
        $this->dumpData = null;

        for ($t = 0; $t < count($this->tables); $t++) { //Loop through all tables, append new data into output file with each loop
            $this->dumpData = "DROP TABLE IF EXISTS " . $this->tables[$t] .  "; \n"; //Drops table if it exists when restoring backup
            file_put_contents(_PATH_ . $this->fileName, $this->dumpData, FILE_APPEND);
            $this->dumpData = null;

            //Prepare structure query statement
            $stmt1 = $this->db->prepare('SHOW CREATE TABLE `' . $this->tables[$t] . '`;');

            //Query table structure
            try {
                $stmt1->execute();
                $fetchData = $stmt1->fetch();
                $this->dumpData = $fetchData[1] . "; \n";
            } catch (PDOException $ex) {
                echo "There was a problem with the database <br>";
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
                        $stmt->execute();
                        $fetchData = $stmt->fetchAll(); //fetchData is data row
                        $fetchData = $fetchData[0];
                    } catch (PDOException $ex) {
                        echo "There was a problem with the database <br>";
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
                        echo "There was a problem with the database <br>";
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
    public function pushDump($filename)
    {
        $this->setUp();
        $pushStatement = $this->db->prepare(file_get_contents(_PATH_ . $filename));
        try {
            $pushStatement->execute();
        } catch (PDOException $ex) {
            echo "There was a problem with the database <br>";
            print_r($ex);
            die();
        }
    }
    
    /**
     * Sends selected backup file to client.
     * 
     * @param string $filename
     */
    public function download($filename)
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Content-disposition: attachment;filename=$filename.sql");
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize(_PATH_ . $filename));
        readfile(_PATH_ . $filename);
    }
    
    /**
     * Saves uploaded file to server dump folder with filename
     *  LISBACKUP_upload_DDMMYYYY_HHMMSS.sql
     * TODO: Sanity checking, that the input file is actually an SQL dump.
     * 
     * @param array $file
     */
    public function upload($file)
    {
        $this->setFileName('upload');
        $filter = \Zend\Filter\File\RenameUpload(array (
            "target" => _PATH_ . $this->fileName,
            "randomize" => false,
            ));
        echo $filter->filter($file);
    }
    
    /**
     * Returns list of backup filenames
     * @return array
     */
    public function getFilenames()
    {
        $dumpList = scandir(_PATH_);
        $dumpList = array_reverse($dumpList);
        array_pop($dumpList);
        array_pop($dumpList);
        return $dumpList;
    }
    
    /**
     * 
     * @return array
     */
    protected function autoDelete($nameList) {
        
    }
    
    //END DB & File handling methods
    //START Session Storage methods and variables
    
    /**
     * @var Storage\StorageInterface
     */
    protected $storage;
    
    /**
     * Returns the persistent storage handler
     *
     * Session storage is used by default unless a different storage adapter has been set.
     *
     * @return Storage\StorageInterface
     */
    public function getStorage()
    {
        if (null === $this->storage) {
            $this->setStorage(new Storage\Session('DumpService'));
        }
        return $this->storage;
    }
    
    /**
     * Sets the persistent storage handler
     *
     * @param  Storage\StorageInterface $storage
     * @return AbstractAdapter Provides a fluent interface
     */
    public function setStorage(Storage\StorageInterface $storage)
    {
        $this->storage = $storage;
        return $this;
    }
    
    /**
     * Returns true if and only if storage is empty
     *
     * @throws \Zend\Authentication\Exception\InvalidArgumentException If it is impossible to determine whether
     * storage is empty or not
     * @return boolean
     */
    public function isEmpty()
    {
        if ($this->getStorage()->isEmpty()) {
            return true;
        }
        $identity = $this->getStorage()->read();
        if ($identity === null) {
            $this->clear();
            return true;
        }
        return false;
    }
    
    /**
     * Returns the contents of storage
     *
     * Behavior is undefined when storage is empty.
     *
     * @throws \Zend\Authentication\Exception\InvalidArgumentException If reading contents from storage is impossible
     * @return mixed
     */
    public function read()
    {
        return $this->getStorage()->read();
    }
    
    /**
     * Writes $contents to storage
     *
     * @param  mixed $contents
     * @throws \Zend\Authentication\Exception\InvalidArgumentException If writing $contents to storage is impossible
     * @return void
     */
    public function write($contents)
    {
        $this->getStorage()->write($contents);
    }
    
    /**
     * Clears contents from storage
     *
     * @throws \Zend\Authentication\Exception\InvalidArgumentException If clearing contents from storage is impossible
     * @return void
     */
    public function clear()
    {
        $this->getStorage()->clear();
    }

    /**
     * Logs out
     * @param int $id
     * @return void
     */
    public function logout()
    {
        $this->getStorage()->clear();
    }
    
    /**
     * Initalizes session to use/get data
     * @return mixed
     */
    private function session()
    {
        $session = new SessionContainer($this->getStorage()->getNameSpace());
        $session->getManager()->regenerateId();
        $storage = $this->getStorage()->read();
        return $storage;
    }
}
