<?php
namespace model;

/**
 *
 * @author Administrator
 *        
 */
class Singer extends BaseCtrl {
    // TODO - Insert your code here
    const TBL_NAME   = 'escolhamusica_tb_singer';

    /**
     */
    public function __construct(/*Database*/ $conn, /*uint*/ $id = BaseCtrl::UNDEFINED) {
        parent::__construct($conn);

        // TODO - Insert your code here
        if ($id != BaseCtrl::UNDEFINED) {
            parent::_fillBaseFields(Singer::TBL_NAME, $id);
        }
    }

    /**
     */
    function __destruct() {
        // TODO - Insert your code here
    }

    /**
     *
     * @param Singer $a
     * @param Singer $b
     * @return int
     */
    static protected /*int*/ function _sortByName(/*Singer*/ $a, /*Singer*/ $b) {
        if (strcasecmp( $a->getName(), $b->getName() ) > 0) {
            return 1;
        }
        else if (strcasecmp( $a->getName(), $b->getName() ) < 0) {
            return -1;
        }
        else {
            return 0;
        }
    }

    /**
     *
     * @param Database $conn
     * @param string $specificCond
     * @return Object[]
     */
    static public function /*Array<Object>*/ getAvailableRecs(/*Database*/ $conn,
                /*string*/ $specificCond = NULL) {
        $mtdRet = parent::getAvailableRecs($conn, $specificCond);

        usort($mtdRet, [Singer::class, '_sortByName']);

        return $mtdRet;
    }

    /*Override*/
    protected function _completeFilling($row) {}

    /*Override*/
    public function save() {
        return parent::_save(Singer::TBL_NAME, parent::_getListBaseFields());
    }
}
