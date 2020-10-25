<?php
require_once '../controller/common.php';

use model\BaseCtrl;
use model\User;
use model\ExecRec;
use model\Song;
use controller\Database;
use model\Category;

$user = new User($_conn, 1);

// $_operId = getHTTPVar(CMD_OPER_TYPE);

$YEAR_TO_LIST = "year";

$currYear = getHTTPVar($YEAR_TO_LIST);

if (empty($currYear)) {
    $currYear = date('Y');
}

$listSongs = ExecRec::getExecutions($_conn, $user, $currYear);

// $_pagOffset = getHTTPVar(CMD_PAG_OFFSET);
?>

<html>
<head>
<title>Listagem de execu&ccedil;&atilde;o</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="bibl.js"></script>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<p><?php include basename(PAG_NAVMENU); ?></p>
    <p>
        <p><a href="<?php echo PAG_LIST_EXEC . '?' . $YEAR_TO_LIST . '=' . ($currYear - 1) ?>"><?php echo ($currYear - 1); ?></a> 
        <a href="<?php echo PAG_LIST_EXEC . '?' . $YEAR_TO_LIST . '=' . $currYear ?>"><?php echo $currYear; ?></a> 
        <a href="<?php echo PAG_LIST_EXEC . '?' . $YEAR_TO_LIST . '=' . ($currYear + 1) ?>"><?php echo ($currYear + 1); ?></a></p>
        <table>
<?php
$MAX_COLS = 2;

$tdCnt = 0;

for ($iElem = 0; $iElem < count($listSongs); $iElem++) {
    $exec = $listSongs[$iElem];

    if ($tdCnt == $MAX_COLS + 1) {
        $tdCnt = 0;
    }

    if ($tdCnt == 0) { ?>
            <tr>
<?php
    } ?>
                <td>
                    <table>
                        <tr>
                            <td>Data:</td>
                            <td><a href="<?php echo PAG_MNG_EXEC . "?" .
                                CMD_OPER_TYPE . "=" . OPER_TYPE_EDIT . "&" .
                                BaseCtrl::COL_ID_STR . "=" . $exec->getId(); ?>"><?php echo $exec->getDate(); ?></a></td>
                        </tr>
                        <tr>
                            <td>M&uacute;sicas:</td>
                            <td>
                                <table>
<?php
    foreach ($exec->getSongsList() as $song) { ?>
                                    <tr>
                                        <td><a href="<?php echo PAG_MNG_SONG . '?' . CMD_OPER_TYPE . '=' . OPER_TYPE_EDIT . '&' . Song::COL_ID_STR . '=' . $song->getId(); ?>"><?php echo $song; ?></a></td>
                                    </tr>
<?php
    } ?>
                               </table>
                            </td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                    </table>
                </td>
<?php
    if ( ($tdCnt == $MAX_COLS - 1) ||
        ( $iElem == count($listSongs) - 1 ) ) { ?>
            </tr>
<?php
        $tdCnt = 0;
    }
    else {
        $tdCnt++;
    }
} ?>
        </table>
    </p>
</body>
</html>
