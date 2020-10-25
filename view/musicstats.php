<?php
require_once '../controller/common.php';

use model\User;
use model\ExecRec;
use model\Song;
use controller\Database;
use model\Category;

$user = new User($_conn, 1);

$listSongs = ExecRec::getSongsStatics($_conn, $user);

$listWorship = array();
$listAdoration = array();

foreach ($listSongs as $currElem => $triple) {
    $song = $triple[0];
    $lastExec = $triple[2];

    if ($song->getCategory()->getId() == Category::CATEG_TYPE_ADORATION) {
        $listAdoration[$currElem] = $lastExec;
    }
    else {
        $listWorship[$currElem] = $lastExec;
    }
}

asort($listAdoration);
asort($listWorship);

// $_pagOffset = getHTTPVar(CMD_PAG_OFFSET);
?>

<html>
<head>
<title>Estat&iacute;stica das M&uacute;sicas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="bibl.js"></script>
</head>
<body bgcolor="#FFFFFF" text="#000000">
    <p><?php include basename(PAG_NAVMENU); ?></p>
    <p>
        <table>
            <tr>
<?php
$data = array();

$data[] = array('Adoraci&oacute;n', $listAdoration);
$data[] = array('J&uacute;bilo', $listWorship);

for ($iter = 0; $iter < 2; $iter++) { ?>
                <td>
                    <p><b><?php echo $data[$iter][0] ?></b></p>
                    <table border="1">
                        <tr>
                            <td><i>Nome</i></td>
                            <td><i>Quantidade</i></td>
                            <td><i>Data</i></td>
                        </tr>
            <?php foreach ($data[$iter][1] as $currElem => $lastExecDate) { ?>
                        <tr>
                            <td><a href="<?php echo PAG_MNG_SONG . '?' . CMD_OPER_TYPE . '=' . OPER_TYPE_EDIT . '&' . Song::COL_ID_STR . '=' . $listSongs[$currElem][0]->getId(); ?>"><?php echo $listSongs[$currElem][0]; ?></a></td>
                            <td><?php echo $listSongs[$currElem][1]; ?></td>
                            <td><?php $execDate = $listSongs[$currElem][2]; echo ($execDate == ExecRec::DATE_NEVER_PLAYED) ? 'Nunca tocada' : $execDate; ?></td>
                        </tr>
            <?php } ?>
                    </table>
                </td>
                <td>&nbsp;</td>
<?php } ?>
            </tr>
        </table>
    </p>
</body>
</html>
