<?php
namespace model;

use controller\Database;

require_once ('common.php');

/**
 *
 * @author Administrator
 *
 */
class ExecRec extends BaseCtrl {
    // TODO - Insert your code here
    const   DATE_NEVER_PLAYED   = 19800101,

            COL_USER    = 1,
            COL_SONGS   = 2,
            COL_DATE    = 3,

            COL_USER_STR      = 'user',
            COL_SONGS_STR     = 'songs',
            COL_DATE_STR      = 'date',

            TBL_NAME        = 'escolhamusica_tb_exec';

    /**
     * 
     * @var array[Song => int]
     */
    protected static /*array<int, array<Song, int, int>*/ $_songsList = array(/*int idSong, Array<Song, qtyExec, lastExecDate>*/),
                    /*int*/ $_fnExec = FALSE;

    private /*User*/ $_user,
            /*Array<Song>*/ $_songs,
            /*uint*/ $_date;

    /**
     *
     * @param Database $conn
     * @param User $user
     * @param int $dateOrId
     */
    public function __construct(/*Database*/ $conn, /*User*/ $user,
                                /*uint*/ $dateOrId = BaseCtrl::UNDEFINED) {
        parent::__construct($conn);

        $this->setUser($user);

        // TODO - Insert your code here
        if ($dateOrId != BaseCtrl::UNDEFINED) {
            $cmdQuery    = "SELECT * FROM " . ExecRec::TBL_NAME . " WHERE " .
                            ExecRec::COL_USER_STR . " = " . $user->getId() . " AND ";

            $cmdQuery .= ($dateOrId > ExecRec::DATE_NEVER_PLAYED) ?
                            ExecRec::COL_DATE_STR : BaseCtrl::COL_ID_STR;

            $cmdQuery .= " = $dateOrId";

            $_resQuery = parent::getDBConn()->getSrvHnd()->query($cmdQuery);

            if ($_resQuery === FALSE) {
                throw new \Exception(BaseCtrl::ERROR_REC_NOT_FOUND[0], BaseCtrl::ERROR_REC_NOT_FOUND[1]);
            }

            while ( $_row = $_resQuery->fetch() ) {
                $this->setId($_row[BaseCtrl::COL_ID]);

                $this->_completeFilling($_row);
            }
        }
        else {
            $this->setDate( date("Ymd") );
        }
    }

    /**
     */
    function __destruct() {
        // TODO - Insert your code here
    }

    /*Override*/
    protected function _completeFilling($row) {
        $this->setUser( new User( $this->getDBConn(), $row[ExecRec::COL_USER] ) );

        $songsIds = explode( ";", $row[ExecRec::COL_SONGS] );

        $listSongs = array();

        foreach ($songsIds as $songId) {
            $listSongs[] = self::_insertSong($this->getDBConn(), $songId, $row[ExecRec::COL_DATE]);
        }

        $this->setSongsList($listSongs);

        $this->setDate( $row[ExecRec::COL_DATE] );
    }

    /**
     * 
     * @return array[]Song
     */
    function /*Array<Song>*/ getSongsList() {
        return $this->_songs;
    }

    /**
     *
     * @param array[]Song $list
     */
    function /*void*/ setSongsList(/*Array<Song>*/ $list) {
        $this->_songs = $list;
    }

    function /*uint*/ getDate() {
        return $this->_date;
    }

    /**
     * @param int $dateOrId
     */
    function /*void*/ setDate(/*uint*/ $dateOrId) {
        $this->_date = $dateOrId;
    }

    /**
     *
     * @return User
     */
    function /*User*/ getUser() {
        return $this->_user;
    }

    /**
     *
     * @param User $user
     */
    function /*void*/ setUser(/*User*/ $user) {
        $this->_user = $user;
    }

    /**
     * 
     * @param Database $conn
     * @param int|Song $songid
     * @param int $execDate
     * @return Song
     */
    static protected function /*Song*/ _insertSong(/*Database*/ $conn, /*int|Song*/ $songObj, /*int*/ $execDate) {
        $mtdRet = NULL;

        $songid = $songObj;

        if ($songObj instanceof Song) {
            $mtdRet = $songObj;

            $songid = $songObj->getId();
        }

        $qtyExec = ($execDate == ExecRec::DATE_NEVER_PLAYED) ? -1 : 0;

        foreach (self::$_songsList as $idInList => $pairValue) {
            if ($idInList == $songid) {
                $qtyExec =$pairValue[1];

                $mtdRet = $pairValue[0];

                if ($pairValue[2] < $execDate) {
                    $pairValue[2] = $execDate;
                }

                break;
            }
        }

        if ( is_null($mtdRet) ) {
            $mtdRet = new Song($conn, $songid);
        }

        self::$_songsList[$songid] = array($mtdRet, ++$qtyExec, $execDate);

        return $mtdRet;
    }

    /**
     *
     * @param ExecRec $a
     * @param ExecRec $b
     * @return int
     */
    static protected /*int*/ function _sortByDate(/*ExecRec*/ $a, /*ExecRec*/ $b) {
        return $a->getDate() > $b->getDate();
    }

    static protected /*void*/ function _fillSongList(/*Database*/ $conn) {
        $listAllSongs = Song::getAvailableSongs($conn);

        foreach ($listAllSongs as $songId) {
            self::_insertSong($conn, $songId, ExecRec::DATE_NEVER_PLAYED);
        }
    }

    /**
     * 
     * @param Database $conn
     * @param User $user
     * @return array[]Song, int, int
     */
    static public function /*array[Song, qtyExec]*/ getSongsStatics(/*Database*/ $conn, /*User*/ $user, /*int*/ $year = NULL) {
        if (! self::$_fnExec) {
            self::getExecutions($conn, $user, $year);
        }

        return array_values(self::$_songsList);
    }

    /**
     *
     * @param Database $conn
     * @param User $categ
     * @return \model\ExecRec[]
     */
    static public function /*Array<Song>*/ getExecutions(/*Database*/ $conn, /*User*/ $user, /*int*/ $year = NULL) {
        ExecRec::_fillSongList($conn);

        $mtdRet = array();

        $cmdQuery = "SELECT " . BaseCtrl::COL_ID_STR . "," . ExecRec::COL_DATE_STR .
                        " FROM " . ExecRec::TBL_NAME;

        $cmdQuery .= " WHERE " . ExecRec::COL_USER_STR . " = " . $user->getId();

        if ( ! is_null($year) && ( strlen($year) == 4) ) {
            $currDate = new \DateTime();

            $currDate->setDate($year - 1, 12, 1);
            $currDate->modify('last day of');
            $lastDayPastYear = $currDate->format('Ymd');

            $currDate->setDate($year, 12, 1);
            $currDate->modify('last day of');
            $lastDayCurrYear = $currDate->format('Ymd');

            $cmdQuery .= " AND date > " . $lastDayPastYear . " AND date <= " . $lastDayCurrYear;
        }

        $_resQuery = $conn->getSrvHnd()->query($cmdQuery);

        if ($_resQuery !== FALSE) {
            while ( $_row = $_resQuery->fetch() ) {
                $mtdRet[] = new ExecRec($conn, $user, $_row[ExecRec::COL_DATE_STR]);
            }
        }

        uasort($mtdRet, [ExecRec::class, '_sortByDate']);

        self::$_fnExec =TRUE;

        return $mtdRet;
    }

    public function save() {
        $_pairValue = array();

        $_pairValue[BaseCtrl::COL_ID_STR] =  $this->getId();
        $_pairValue[ExecRec::COL_USER_STR] = $this->getUser()->getId();

        $csvSong = "";

        $listSz = count($this->getSongsList());
        $currItem = 0;

        foreach ($this->getSongsList() as $currSong) {
            $csvSong .= $currSong->getId();

            if ( ($currItem + 1) != $listSz ) {
                $csvSong .= ";";
            }

            $currItem++;
        }

        $_pairValue[ExecRec::COL_SONGS_STR] = "'$csvSong'";
        $_pairValue[ExecRec::COL_DATE_STR] = $this->getDate();

        return parent::_save(ExecRec::TBL_NAME, $_pairValue);
    }
}
