<?php
require_once '../controller/common.php';

use model\Singer;
use controller\Database;
use model\Category;
use model\BaseCtrl;

// $user = new User($_conn, 1);

$classType = getHTTPVar(CMD_CLASS_TYPE);

if ( empty($classType) ) {
    $classType = CLASS_TYPE_SINGER;
}

$newInstance = $classType == CLASS_TYPE_SINGER ? new Singer($_conn) : new Category($_conn);

$listRecs = $newInstance->getAvailableRecs($_conn);

// $_pagOffset = getHTTPVar(CMD_PAG_OFFSET);
?>

<html>
<head>
<title>Listagem de <?php if ($classType == CLASS_TYPE_SINGER) { echo 'cantor'; } else { echo 'categoria'; } ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="bibl.js"></script>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<p><?php include basename(PAG_NAVMENU); ?></p>
    <p>
        <table>
<?php
$MAX_COLS = 2;

$tdCnt = 0;

for ($iElem = 0; $iElem < count($listRecs); $iElem++) {
    $rec = $listRecs[$iElem];

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
                            <td>Nome:</td>
                            <td><a href="<?php echo PAG_MNG_BASE . "?" .
                                CMD_OPER_TYPE . "=" . OPER_TYPE_EDIT . "&" .
                                CMD_CLASS_TYPE . "=$classType&" .
                                BaseCtrl::COL_ID_STR . "=" . $rec->getId(); ?>"><?php echo $rec->getName(); ?></a></td>
                        </tr>
                    </table>
                </td>
<?php
    if ( ($tdCnt == $MAX_COLS - 1) ||
        ( $iElem == count($listRecs) - 1 ) ) { ?>
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
