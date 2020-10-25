<?php
require_once 'common.php';

use \model\User;
?>

<html>
<head>
<title>Editar usu&aacute;rio</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="bibl.js"></script>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<p><?php include basename(PAG_NAVMENU); ?></p>

<form name="frmVisualiz" method="post" action="<?php echo PAG_USER; ?>">
    <input type="hidden" name="<?php echo CMD_OPER_TYPE; ?>" id="<?php echo CMD_OPER_TYPE; ?>" value="<?php echo OPER_TYPE_NEW; ?>";
    <p>Digite as informa&ccedil;&otilde;es &aacute; seguir:</p>
    <p>Name: <input type="text" name="<?php echo User::COL_ID_STR; ?>"
                    id="<?php echo User::COL_ID_STR; ?>" value=""><br>
        Password: <input type="text" name="<?php echo User::COL_ID_STR; ?>"
                    id="<?php echo User::COL_ID_STR; ?>" value=""></p>
    <p><input type="submit" name="_btConfirmar" id="_btConfirmar" value="Confirmar" /></p>
</form>
</body>
</html>