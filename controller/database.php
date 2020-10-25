<?php
namespace controller;

use \PDO;
use \PDOException;

/**
 *
 * @author Administrator
 *        
 */
class Database {
    // TODO - Insert your code here
    private /*string*/ $_nameSrv    = 'localhost',
            /*string*/ $_nameUsr    = 'psgsilva',
            /*string*/ $_pwdUsr     = 'psgsilva',
            /*Object*/ $_hndSrv     = NULL,

            /*string*/ $_nameDB     = 'escolhamusica',

            /*boolean*/ $_connected = FALSE;

    /**
     */
    public function __construct() {
        if ( $this->isConnected() ) {
            return;
        }

        try {
            $dsn = "mysql:host=" . $this->getSrvName() . ";dbname=" . $this->getDBName();

            $this->setSrvHnd( new PDO( $dsn, $this->getUserName(), $this->getUserPwd() ) );
        } catch (PDOException $e){
            die($e);
        }

        $this->setConnected(TRUE);
    }

    /**
     */
    function __destruct() {
        // TODO - Insert your code here
    }

    public /*void*/ function setUserName(/*string*/ $name) {
        $this->_nameUsr = $name;
    }

    public /*string*/ function getUserName() {
        return $this->_nameUsr;
    }

    public /*void*/ function setSrvName(/*string*/ $name) {
        $this->_nameSrv = $name;
    }

    public /*string*/ function getSrvName() {
        return $this->_nameSrv;
    }

    public /*void*/ function setUserPwd(/*string*/ $pwd) {
        $this->_pwdUsr = $pwd;
    }

    public /*string*/ function getUserPwd() {
        return $this->_pwdUsr;
    }

    public /*void*/ function setDBName(/*string*/ $name) {
        $this->_nameDB = $name;
    }

    public /*string*/ function getDBName() {
        return $this->_nameDB;
    }

    public /*void*/ function setSrvHnd(/*Object*/ $conn) {
        $this->_hndSrv = $conn;
    }

    /**
     * 
     * @return PDO
     */
    public /*Object*/ function getSrvHnd() {
        return $this->_hndSrv;
    }

    function /*boolean*/ isConnected() {
        $this->_connected;
    }

    function /*void*/ setConnected(/*boolean*/ $connected) {
        $this->_connected = $connected;
    }
}
