<?php
namespace controller;

use model\User;
use model\ExecRec;
use model\Song;
use model\BaseCtrl;
use controller\Database;
use model\Category;

require_once 'common.php';

$MAX_SONG_CATEG = 6;

$user = new User($_conn, 1);

$_operId = getHTTPVar(CMD_OPER_TYPE);

$fldWorsBaseName = "worship";
$fldAdorBaseName = "adoration";

$recId = getHTTPVar(BaseCtrl::COL_ID_STR);

$newExec = NULL;

// $_pagOffset = getHTTPVar(CMD_PAG_OFFSET);

$listSongs = NULL;

$_operIdFilled = FALSE;

if ( ($isLogged) && ( ! empty($_operId) ) && ( is_numeric($_operId) ) ) {
    if ( ($_operId == OPER_TYPE_NEW) ||
        ($_operId == OPER_TYPE_SAVE) ) {
        $listSongs = array();

        $categList = [Category::CATEG_TYPE_ADORATION => $fldAdorBaseName,
                        Category::CATEG_TYPE_WORSHIP => $fldWorsBaseName];

        for ($currCateg = Category::CATEG_TYPE_ADORATION;
            $currCateg <= Category::CATEG_TYPE_LAST; $currCateg++) {
            $currCategName = $categList[$currCateg];

            $iCount = 1;

            $cond = FALSE;

            do {
                $curVal = getHTTPVar($currCategName . $iCount);

                $cond = ( ! empty($curVal) );

                if ($cond) {
                    if ($curVal > 0) {
                        $listSongs[] = new Song($_conn, $curVal);
                    }
                }

                $iCount++;
            } while ($cond);
        }

        if ( ! empty($listSongs) ) {
            if ($_operId == OPER_TYPE_NEW) {
                $theDateOrId = BaseCtrl::UNDEFINED;
            }
            else {
                $theDateOrId = $recId;
            }

            $newExec = new ExecRec($_conn, $user, $theDateOrId);

            $recDate = getHTTPVar(ExecRec::COL_DATE_STR);

            if ( ! empty($recDate) ) {
                $newExec->setDate($recDate);
            }

            $newExec->setSongsList($listSongs);

            $newExec->save();

            $_operIdFilled = TRUE;
        }
    }
    else if ($_operId == OPER_TYPE_EDIT) {
        if ( ! empty($recId) ) {
            $execRec = new ExecRec($_conn, $user, $recId);

            $listSongs = $execRec->getSongsList();

            $_operId = OPER_TYPE_SAVE;

            $recDate = $execRec->getDate();

            $_operIdFilled = TRUE;
        }
    }
}

if (! $_operIdFilled) {
    $_operId = OPER_TYPE_NEW;

    $recDate = ( new ExecRec($_conn, $user) )->getDate();
}

$listWorship = Song::getAvailableSongs($_conn, new Category($_conn, Category::CATEG_TYPE_WORSHIP));
$listAdoration = Song::getAvailableSongs($_conn, new Category($_conn, Category::CATEG_TYPE_ADORATION));

function /*string*/ _mountSelect(/*int*/ $type = 0) {
    global  $listWorship,
            $listAdoration,
            $listSongs;

    $mtdRet = "<option value=\"0\">Ninguna</option>";

    $arrSongs = NULL;

    if ($type == 0) {
        $arrSongs = $listWorship;
    }
    else {
        $arrSongs = $listAdoration;
    }

    $foundInThisMount = empty($listSongs);

    foreach ($arrSongs as $song) {
        $auxText = '';

        if (! $foundInThisMount) {
            for ($iCnt = 0; $iCnt < count($listSongs); $iCnt++) {
                $songInExec = $listSongs[$iCnt];

                if ( $song->getId() == $songInExec->getId() ) {
                    $auxText = " selected ";

                    array_splice($listSongs, $iCnt, 1);

                    $foundInThisMount = TRUE;

                    break;
                }
            }
        }

        $mtdRet .= "<option value=\"" . $song->getId() . "\"$auxText>$song</option>" . PHP_EOL;
    }

    return $mtdRet;
}

?>

<html>
<head>
<title>Editar execu&ccedil;&atilde;o</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="bibl.js"></script>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<p><?php include basename(PAG_NAVMENU); ?></p>

<form name="frmVisualiz" method="post" action="<?php echo PAG_MNG_EXEC; ?>">
    <p><input type="hidden" name="<?php echo CMD_OPER_TYPE; ?>" id="<?php echo CMD_OPER_TYPE; ?>" value="<?php echo $_operId; ?>">
    <input type="hidden" name="<?php echo BaseCtrl::COL_ID_STR; ?>" id="<?php echo BaseCtrl::COL_ID_STR; ?>" value="<?php echo $recId; ?>">
        <table>
            <tr>
                <td>Data:</td>
                <td><input type="text" name="<?php echo ExecRec::COL_DATE_STR; ?>"
                    id="<?php echo ExecRec::COL_DATE_STR; ?>" value="<?php echo $recDate; ?>"></td>
            </tr>
            <tr>
                <td>M&uacute;sicas:</td>
                <td>
                    <table>
<?php for ($count = 1; $count <= $MAX_SONG_CATEG; $count++) { ?>
                        <tr>
                            <td>
                                <select name="<?php echo $fldWorsBaseName . $count; ?>" id="<?php echo $fldWorsBaseName . $count; ?>">
                                    <?php echo _mountSelect(); ?>
                                </select>
                            </td>
                        </tr>
<?php } ?>
<tr><td>&nbsp;</td></tr>
<?php for ($count = 1; $count <= $MAX_SONG_CATEG; $count++) { ?>
                        <tr>
                            <td>
                                <select name="<?php echo $fldAdorBaseName . $count; ?>" id="<?php echo $fldAdorBaseName . $count; ?>">
                                    <?php echo _mountSelect(1); ?>
                                </select>
                            </td>
                        </tr>
<?php } ?>
        </table>
    </p>
    <?php if ($isLogged) { ?><p><input type="submit" name="_btConfirmar" id="_btConfirmar" value="Confirmar" /></p><?php } ?>
</form>
</body>
</html>
