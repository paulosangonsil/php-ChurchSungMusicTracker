<?php
namespace model;

use controller\Database;
use Exception;

/**
 *
 * @author Administrator
 *        
 */
abstract class BaseCtrl {
    // TODO - Insert your code here
    const   UNDEFINED   = -1,

            ERROR_REC_NOT_FOUND = ['Record not found', -1],

            COL_ID      = 0,
            COL_NAME    = 1,

            COL_ID_STR      = 'id',
            COL_NAME_STR    = 'name';

    private /*uint*/ $_id   = BaseCtrl::UNDEFINED,
            /*string*/ $_name,
            /*Database*/ $_conn;

    /**
     * 
     * @param Database $conn
     */
    public function __construct(/*Database*/ $conn) {
        // TODO - Insert your code here
        $this->setDBConn($conn);
    }

    /**
     */
    function __destruct() {
        // TODO - Insert your code here
    }

    /**
     * 
     * @param mixed $row
     */
    protected abstract /*void*/ function _completeFilling(/*mixed*/ $row);

    protected /*void*/ function _fillBaseFields(/*string*/ $tblName, /*uint*/ $id) {
        $cmdQuery    = "SELECT * FROM $tblName WHERE " . BaseCtrl::COL_ID_STR ." = $id";

        $_resQuery = $this->getDBConn()->getSrvHnd()->query($cmdQuery);

        if ($_resQuery === FALSE) {
            return;
        }

        while ( $_row = $_resQuery->fetch() ) {
            $this->setId($_row[BaseCtrl::COL_ID]);
            $this->setName($_row[BaseCtrl::COL_NAME]);

            $this->_completeFilling($_row);
        }
    }

    /**
     * 
     * @return int
     */
    function /*int*/ getId() {
        return $this->_id;
    }

    function /*void*/ setId(/*int*/ $id) {
        $this->_id = $id;
    }

    /**
     * @return String
     */
    function /*string*/ getName() {
        return $this->_name;
    }

    function /*void*/ setName(/*string*/ $name) {
        if (! empty($name)) {
            $this->_name = $name;
        }
    }

    /**
     * 
     * @return Database
     */
    function /*Database*/ getDBConn() {
        return $this->_conn;
    }

    /**
     * 
     * @param Database $conn
     */
    function /*void*/ setDBConn(/*Database*/ $conn) {
        $this->_conn = $conn;
    }

    abstract function save();

    /**
     * 
     * @return array<string, object>
     */
    protected function /*Set<string, Object>*/ _getListBaseFields() {
        $mtdRet = array();

        $mtdRet[BaseCtrl::COL_ID_STR] = $this->getId();
        $mtdRet[BaseCtrl::COL_NAME_STR] = "'" . $this->getName() . "'";

        return $mtdRet;
    }

    /**
     * 
     * @param string $tblName
     * @param array<string, Object> $_pairValue
     * @return \PDOStatement
     */
    protected function /*int*/ _save(/*string*/ $tblName, /*Set<string, Object>*/ $_pairValue) {
        if ($this->getId() == BaseCtrl::UNDEFINED) {
            $cmd = "INSERT INTO $tblName VALUES(NULL";

            foreach ($_pairValue as $key => $value) {
                if (strcmp(BaseCtrl::COL_ID_STR, $key) != 0) {
                    if (empty($value)) {
                        $value = 'NULL';
                    }

                    $cmd .= ", $value";
                }
            }

            $cmd .= ")";
        }
        else {
            $cmd = "UPDATE $tblName SET ";

            $listSz = count($_pairValue);

            $currItem = 0;

            foreach ($_pairValue as $key => $value) {
                if (empty($value)) {
                    $value = 'NULL';
                }

                $cmd .= "$key = $value";

                if ( ($currItem + 1) != $listSz ) {
                    $cmd .= ", ";
                }

                $currItem++;
            }

            $cmd .= " WHERE " . BaseCtrl::COL_ID_STR . " = " . $this->getId();
        }

        return $this->getDBConn()->getSrvHnd()->query($cmd);
    }

    /**
     *
     * @param Database $conn
     * @param string $specificCond
     * @return Object[]
     */
    static public function /*Array<Object>*/ getAvailableRecs(/*Database*/ $conn,
                /*string*/ $specificCond = NULL) {
        $mtdRet = array();

        $cmdQuery = "SELECT " . BaseCtrl::COL_ID_STR . " FROM " . static::TBL_NAME;

        if ($specificCond != NULL) {
            $cmdQuery .= " WHERE " . $specificCond;
        }

        $_resQuery = $conn->getSrvHnd()->query($cmdQuery);

        if ($_resQuery !== FALSE) {
            while ( $_row = $_resQuery->fetch() ) {
                $class = new \ReflectionClass(static::class);

                $mtdRet[] = $class->newInstanceArgs( array($conn, $_row[BaseCtrl::COL_ID]) );
            }
        }

        return $mtdRet;
    }

    /*Override*/
    public function __toString() {
        try {
            return $this->getName();
        }
        catch (Exception $exception) {
            return '';
        }
    }
}
