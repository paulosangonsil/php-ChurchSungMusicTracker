<?php
namespace controller;

use model\BaseCtrl;
use model\User;
use model\Song;
use model\Singer;
use controller\Database;
use model\Category;

require_once 'common.php';

const   FLD_SONG_NAME   = 'song' . Song::COL_NAME_STR,
        FLD_CATEG_NAME  = 'categ' . Category::COL_NAME_STR;

// $newSong = new Song($_conn, $user);

$_operId = getHTTPVar(CMD_OPER_TYPE);
// $execDate = getHTTPVar(Song::COL_DATE_STR);

// $_pagOffset = getHTTPVar(CMD_PAG_OFFSET);

// $seqTarefas = NULL;

$id = BaseCtrl::UNDEFINED;
$categ = '';
$aux = '';
$link = '';
$linkKaraoke = '';
$name = '';
$text = '';
$singer = '';

$treated = false;

if ( ($isLogged) && ( ! is_null($_operId) ) && ( is_numeric($_operId) ) ) {
    $id = getHTTPVar(Song::COL_ID_STR);
    $categ = getHTTPVar(FLD_CATEG_NAME);
    $aux = getHTTPVar(Song::COL_CATEGAUX_STR);
    $link = getHTTPVar(Song::COL_LINK_STR);
    $linkKaraoke = getHTTPVar(Song::COL_KARAOKE_STR);
    $name = getHTTPVar(FLD_SONG_NAME);
    $text = getHTTPVar(Song::COL_NOTES_STR);
    $singer = getHTTPVar(Song::COL_SINGER_STR);

    switch ($_operId) {
        case OPER_TYPE_NEW:
        case OPER_TYPE_SAVE: {
            $isDataOk = TRUE;

            $fldNames = [$categ, $name, $singer];

            if ($_operId == OPER_TYPE_SAVE) {
                $fldNames[] = $id;
            }

            foreach ($fldNames as $currFld) {
                $isDataOk = ! empty($currFld);

                if (! $isDataOk) {
                    break;
                }
            }

            if ($isDataOk) {
                if ($_operId == OPER_TYPE_NEW) {
                    $id = BaseCtrl::UNDEFINED;
                }

                $newSong = new Song($_conn, $id);

                $newSong->setCategory( new Category($_conn, $categ) );
                $newSong->setCategoryAux($aux);
                $newSong->setLinkMusic($link);
                $newSong->setLinkMusicKaraoke($linkKaraoke);
                $newSong->setName($name);
                $newSong->setNotes($text);
                $newSong->setSinger( new Singer($_conn, $singer) );

                $newSong->save();

                $_operId = OPER_TYPE_SAVE;

                $treated = TRUE;
            }

            break;
        }

        case OPER_TYPE_EDIT: {
            if ( ! empty($id) ) {
                $_operId = OPER_TYPE_SAVE;

                $theSong = new Song($_conn, $id);

                $id = $theSong->getId();
                $categ = $theSong->getCategory()->getId();
                $aux = $theSong->getCategoryAux();
                $link = $theSong->getLinkMusic();
                $linkKaraoke = $theSong->getLinkMusicKaraoke();
                $name = $theSong->getName();
                $text = $theSong->getNotes();
                $singer = $theSong->getSinger()->getId();

                $treated = TRUE;
            }

            break;
        }
    }
}

if (! $treated) {
    $_operId = OPER_TYPE_NEW;
}

$listSinger = Singer::getAvailableRecs($_conn);
$listCategory = Category::getAvailableRecs($_conn);

/**
 * 
 * @param array[]BaseCtrl $list
 * @return string
 */
function /*string*/ _mountBaseSelect(/*array[]BaseCtrl*/ $list, /*int*/ $selected) {
    $mtdRet = '';

    foreach ($list as $instance) {
        $auxText = '';

        if ($instance->getId() == $selected) {
            $auxText = " selected ";
        }

        $mtdRet .= "<option value=\"" . $instance->getId() . "\"$auxText>" . $instance->getName() . "</option>" . PHP_EOL;
    }

    return $mtdRet;
}

?>

<html>
<head>
<title>Editar m&uacute;sica</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="bibl.js"></script>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<p><?php include basename(PAG_NAVMENU); ?></p>
<form name="frmVisualiz" method="post" action="<?php echo PAG_MNG_SONG; ?>">
    <p>
        <input type="hidden" name="<?php echo CMD_OPER_TYPE; ?>" id="<?php echo CMD_OPER_TYPE; ?>" value="<?php echo $_operId; ?>">
        <input type="hidden" name="<?php echo Song::COL_ID_STR; ?>" id="<?php echo Song::COL_ID_STR; ?>" value="<?php echo $id; ?>">
        <table>
            <tr>
                <td>Cantor:</td>
                <td><select name="<?php echo Song::COL_SINGER_STR; ?>" id="<?php echo Song::COL_SINGER_STR; ?>">
                        <?php echo _mountBaseSelect($listSinger, $singer); ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Nome:</td>
                <td><input type="text" name="<?php echo FLD_SONG_NAME; ?>" id="<?php echo FLD_SONG_NAME; ?>" value="<?php echo $name; ?>"></td>
            </tr>
            <tr>
                <td>Categoria:</td>
                <td><select name="<?php echo FLD_CATEG_NAME; ?>" id="<?php echo FLD_CATEG_NAME; ?>">
                        <?php echo _mountBaseSelect($listCategory, $categ); ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Detalhe Categoria:</td>
                <td><input type="text" name="<?php echo Song::COL_CATEGAUX_STR; ?>" id="<?php echo Song::COL_CATEGAUX_STR; ?>" value="<?php echo $aux; ?>"></td>
            </tr>
            <tr>
                <td>Link YouTube:</td>
                <td><input type="text" name="<?php echo Song::COL_LINK_STR; ?>" id="<?php echo Song::COL_LINK_STR; ?>" value="<?php echo $link; ?>"></td>
            </tr>
            <tr>
                <td>Link YouTube Playback:</td>
                <td><input type="text" name="<?php echo Song::COL_KARAOKE_STR; ?>" id="<?php echo Song::COL_KARAOKE_STR; ?>" value="<?php echo $linkKaraoke; ?>"></td>
            </tr>
            <tr>
                <td>Observa&ccedil;&otilde;es:</td>
                <td><input type="text" name="<?php echo Song::COL_NOTES_STR; ?>" id="<?php echo Song::COL_NOTES_STR; ?>" value="<?php echo $text; ?>"></td>
            </tr>
        </table>
    </p>
    <?php if ($isLogged) { ?><p><input type="submit" name="_btConfirmar" id="_btConfirmar" value="Confirmar" /></p><?php } ?>
</form>
</body>
</html>
