<?php
namespace model;

use Exception;
use controller\Database;

/**
 *
 * @author Administrator
 *        
 */
class Song extends BaseCtrl {
    // TODO - Insert your code here
    const   COL_SINGER      = 2,
            COL_CATEG       = 3,
            COL_CATEGAUX    = 4,
            COL_LINK        = 5,
            COL_KARAOKE     = 6,
            COL_NOTES       = 7,

            COL_SINGER_STR      = 'singer',
            COL_CATEG_STR       = 'category',
            COL_CATEGAUX_STR    = 'category_aux',
            COL_LINK_STR        = 'link_ytube',
            COL_KARAOKE_STR     = 'link_pback_ytube',
            COL_NOTES_STR       = 'notes',

            TBL_NAME        = 'escolhamusica_tb_song';

    private /*Singer*/ $_singer,
            /*Category*/ $_category,
            /*uint*/ $_categoryAux = NULL,
            /*string*/ $_link_music = NULL,
            /*string*/ $_link_music_karaoke = NULL,
            /*string*/ $_notes = NULL;

    /**
     */
    public function __construct(/*Database*/ $conn, /*uint*/ $id = BaseCtrl::UNDEFINED) {
        parent::__construct($conn);

        // TODO - Insert your code here
        if ($id != BaseCtrl::UNDEFINED) {
            parent::_fillBaseFields(Song::TBL_NAME, $id);
        }
    }

    /**
     */
    function __destruct() {
        // TODO - Insert your code here
    }

    /*Override*/
    protected function _completeFilling($row) {
        $this->setSinger( new Singer( $this->getDBConn(), $row[Song::COL_SINGER] ) );
        $this->setCategory( new Category( $this->getDBConn(), $row[Song::COL_CATEG] ) );
        $this->setCategoryAux( $row[Song::COL_CATEGAUX] );
        $this->setLinkMusic( $row[Song::COL_LINK] );
        $this->setLinkMusicKaraoke( $row[Song::COL_KARAOKE] );
        $this->setNotes( $row[Song::COL_NOTES] );
    }

    /**
     * 
     * @return Singer
     */
    function /*Singer*/ getSinger() {
        return $this->_singer;
    }

    function /*void*/ setSinger(/*Singer*/ $singer) {
        if ($singer > 0) {
            $this->_singer = $singer;
        }
    }

    /**
     * 
     * @return Category
     */
    function /*Category*/ getCategory() {
        return $this->_category;
    }

    function /*void*/ setCategory(/*Category*/ $categ) {
        if ($categ > 0) {
            $this->_category = $categ;
        }
    }

    function /*uint*/ getCategoryAux() {
        return $this->_categoryAux;
    }

    function /*void*/ setCategoryAux(/*uint*/ $aux) {
        $this->_categoryAux = $aux;
    }

    function /*string*/ getLinkMusic() {
        return $this->_link_music;
    }

    function /*void*/ setLinkMusic(/*string*/ $link) {
        $this->_link_music = $link;
    }

    /**
     * 
     * @return string
     */
    function /*string*/ getLinkMusicKaraoke() {
        return $this->_link_music_karaoke;
    }

    /**
     * 
     * @param string $link
     */
    function /*void*/ setLinkMusicKaraoke(/*string*/ $link) {
        $this->_link_music_karaoke = $link;
    }

    /**
     * 
     * @return string
     */
    function /*string*/ getNotes() {
        return $this->_notes;
    }

    /**
     * 
     * @param string $text
     */
    function /*void*/ setNotes(/*string*/ $text) {
        $this->_notes = $text;
    }

    /**
     * 
     * @param string $a
     * @param string $b
     */
    static protected /*int*/ function _sortString(/*string*/ $a, /*string*/ $b) {
        $mtdRet = 0;

        $iEnd = strlen($a);
        $iPos = strlen($b);

        if ($iPos < $iEnd) {
            $iEnd = $iPos;
        }

        for ($iPos = 0; $iPos < $iEnd; $iPos++) {
            if ($a[$iPos] != $b[$iPos]) {
                break;
            }
        }

        if ($iEnd != $iPos) {
            if ($a[$iPos] > $b[$iPos]) {
                $mtdRet = 1;
            }
            else {
                $mtdRet = -1;
            }
        }

        return $mtdRet;
    }

    /**
     * 
     * @param Song $a
     * @param Song $b
     * @return int
     */
    static public /*int*/ function _sortByMusicName(/*Song*/ $a, /*Song*/ $b) {
        $mtdRet = Song::_sortString($a->getSinger()->getName(), $b->getSinger()->getName());

        if ($mtdRet == 0) {
            $mtdRet = Song::_sortString($a->getName(), $b->getName());
        }

        return $mtdRet;
    }

    /**
     * 
     * @param Database $conn
     * @param Category $categ
     * @return \model\Song[]
     */
    static public function /*Array<Song>*/ getAvailableSongs(/*Database*/ $conn, /*Category*/ $categ = NULL) {
        $cusFilter = NULL;

        if ($categ != NULL) {
            $cusFilter = Song::COL_CATEG_STR . " = " . $categ->getId();
        }

        $mtdRet = parent::getAvailableRecs($conn, $cusFilter);

        uasort($mtdRet, [Song::class, '_sortByMusicName']);

        return $mtdRet;
    }

    /*Override*/
    public function save() {
        $mtdRet = NULL;

        $isValid = (! empty( $this->getName() ) ) && ($this->getSinger()->getId() > 0) &&
                    ($this->getCategory()->getId() > 0);

        if ($isValid) {
            $fdsValues = parent::_getListBaseFields();

            $fdsValues[Song::COL_SINGER_STR] = $this->getSinger()->getId();
            $fdsValues[Song::COL_CATEG_STR] = $this->getCategory()->getId();
            $fdsValues[Song::COL_CATEGAUX_STR] = $this->getCategoryAux();

            $value = NULL;

            if ( ! empty( $this->getLinkMusic() ) ) {
                $value = "'" . $this->getLinkMusic() . "'";
            }

            $fdsValues[Song::COL_LINK_STR] = $value;

            $value = NULL;

            if ( ! empty( $this->getLinkMusicKaraoke() ) ) {
                $value = "'" . $this->getLinkMusicKaraoke() . "'";
            }

            $fdsValues[Song::COL_KARAOKE_STR] = $value;

            $value = NULL;

            if ( ! empty( $this->getNotes() ) ) {
                $value = "'" . $this->getNotes() . "'";
            }

            $fdsValues[Song::COL_NOTES_STR] = $value;

            $mtdRet = parent::_save(Song::TBL_NAME, $fdsValues);
        }

        return $mtdRet;
    }

    /*Override*/
    public function __toString() {
        try {
            return $this->getSinger()->getName() . ' - ' . $this->getName();
        }
        catch (Exception $exception) {
            return '';
        }
    }
}
