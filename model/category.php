<?php
namespace model;

/**
 *
 * @author Administrator
 *        
 */
class Category extends BaseCtrl {
    // TODO - Insert your code here
    const   TBL_NAME   = 'escolhamusica_tb_categ',

            CATEG_TYPE_ADORATION    = 1,
            CATEG_TYPE_WORSHIP      = 2,
            CATEG_TYPE_LAST         = Category::CATEG_TYPE_WORSHIP;

    /**
     */
    public function __construct(/*Database*/ $conn, /*uint*/ $id = BaseCtrl::UNDEFINED) {
        parent::__construct($conn);

        // TODO - Insert your code here
        if ($id != BaseCtrl::UNDEFINED) {
            parent::_fillBaseFields(Category::TBL_NAME, $id);
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
        return parent::_save(Category::TBL_NAME, parent::_getListBaseFields());
    }
}
