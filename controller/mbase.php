<?php
namespace controller;

use model\BaseCtrl;
use model\Singer;
use controller\Database;
use model\Category;

require_once 'common.php';

// $newSong = new Song($_conn, $user);

$_operId = getHTTPVar(CMD_OPER_TYPE);
$classType = getHTTPVar(CMD_CLASS_TYPE);

if ( empty($classType) ) {
    $classType = CLASS_TYPE_SINGER;
}

$id = BaseCtrl::UNDEFINED;
$name = '';

if ( ($isLogged) && ( ! empty($_operId) ) && ( is_numeric($_operId) ) ) {
    $id = getHTTPVar(BaseCtrl::COL_ID_STR);
    $name = getHTTPVar(BaseCtrl::COL_NAME_STR);

    switch ($_operId) {
        case OPER_TYPE_NEW:
        case OPER_TYPE_SAVE: {
            $isDataOk = TRUE;

            $fldNames = [$name, $classType];

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

                $newInstance = $classType == CLASS_TYPE_SINGER ? new Singer($_conn, $id) : new Category($_conn, $id);

                $newInstance->setName($name);

                $newInstance->save();

                $_operId = OPER_TYPE_NEW;
            }

            break;
        }

        case OPER_TYPE_EDIT: {
            if ( ! empty($id) ) {
                $_operId = OPER_TYPE_SAVE;

                $newInstance = $classType == CLASS_TYPE_SINGER ?
                                new Singer($_conn, $id) : new Category($_conn, $id);

                $name = $newInstance->getName();
            }

            break;
        }
    }
}
else {
    $_operId = OPER_TYPE_NEW;
}
?>

<html>
<head>
<title>Criar/Editar <?php if ($classType == CLASS_TYPE_SINGER) { echo 'cantor'; } else { echo 'categoria'; } ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="bibl.js"></script>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<p><?php include basename(PAG_NAVMENU); ?></p>
<form name="frmVisualiz" method="post" action="<?php echo PAG_MNG_BASE; ?>">
    <p>
        <input type="hidden" name="<?php echo CMD_OPER_TYPE; ?>" id="<?php echo CMD_OPER_TYPE; ?>" value="<?php echo $_operId; ?>">
        <input type="hidden" name="<?php echo BaseCtrl::COL_ID_STR; ?>" id="<?php echo BaseCtrl::COL_ID_STR; ?>" value="<?php echo $id; ?>">
        <input type="hidden" name="<?php echo CMD_CLASS_TYPE; ?>" id="<?php echo CMD_CLASS_TYPE; ?>" value="<?php echo $classType; ?>">
        <table>
            <tr>
                <td>Nome:</td>
                <td><input type="text" name="<?php echo BaseCtrl::COL_NAME_STR; ?>" id="<?php echo BaseCtrl::COL_NAME_STR; ?>" value="<?php echo $name; ?>"></td>
            </tr>
        </table>
    </p>
    <p><input type="submit" name="_btConfirmar" id="_btConfirmar" value="Confirmar" /></p>
</form>
</body>
</html>
