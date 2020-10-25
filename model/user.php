<?php
namespace model;

use controller\Database;

// require_once '../controller/common.php';

/**
 *
 * @author Administrator
 *
 */
class User extends BaseCtrl {
    // TODO - Insert your code here
    const   COL_PASS        = 2,

            COL_PASS_STR    = 'passwd',

            TBL_NAME        = 'escolhamusica_tb_user';

    private     /*string*/ $_passwd,
                /*bool*/ $_isAuthenticated  = FALSE;

    /**
     * 
     * @param Database $conn
     * @param int|string $idOrName
     * @param string $passwd
     */
    public function __construct(/*Database*/ $conn, /*int|string*/ $idOrName = BaseCtrl::UNDEFINED, /*string*/ $passwd = NULL) {
        parent::__construct($conn);

        // TODO - Insert your code here
        if ($idOrName != BaseCtrl::UNDEFINED) {
            if ( ! is_int($idOrName) ) {
                $cmdQuery    = "SELECT " . User::COL_ID_STR . " FROM " . User::TBL_NAME . " WHERE " .
                    User::COL_NAME_STR . " = '$idOrName'";

                $_resQuery = parent::getDBConn()->getSrvHnd()->query($cmdQuery);

                if ($_resQuery === FALSE) {
                    throw new \Exception(BaseCtrl::ERROR_REC_NOT_FOUND[0], BaseCtrl::ERROR_REC_NOT_FOUND[1]);
                }

                while ( $_row = $_resQuery->fetch() ) {
                    $idOrName = $_row[BaseCtrl::COL_ID];
                }
            }

            parent::_fillBaseFields(User::TBL_NAME, $idOrName);
        }

        if ( (! is_null($passwd) &&
            ( strcmp( $passwd, $this->getPasswd() ) == 0) ) ) {
            $this->_setAuthenticated();
        }
    }

    /**
     */
    function __destruct() {
        // TODO - Insert your code here
    }

    /*Override*/
    protected function _completeFilling($row) {
        $this->setPasswd( $row[User::COL_PASS] );
    }

    function /*string*/ getPasswd() {
        return $this->_passwd;
    }

    function /*void*/ setPasswd(/*string*/ $passwd) {
        $this->_passwd = $passwd;
    }

    function /*bool*/ isAuthenticated() {
        return $this->_isAuthenticated;
    }

    protected function /*void*/ _setAuthenticated() {
        $this->_isAuthenticated = TRUE;
    }

    /*Override*/
    public function save() {
        $fdsValues = parent::_getListBaseFields();

        $fdsValues[User::COL_PASS_STR] = $this->getPasswd();

        return parent::_save(User::TBL_NAME, $fdsValues);
    }
}
