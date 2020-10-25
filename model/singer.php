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

    /*Override*/
    protected function _completeFilling($row) {}

    /*Override*/
    public function save() {
        return parent::_save(Singer::TBL_NAME, parent::_getListBaseFields());
    }
}
