<?php
require_once '../controller/common.php';

const   FLD_USR_PASSWD  = 'asdf',
        FLD_USR_NAME    = 'qwer';

if (! $isLogged) {
    $passwd = getHTTPVar(FLD_USR_PASSWD);
    $username = getHTTPVar(FLD_USR_NAME);

    if (! is_null($username) && ! is_null($passwd) ) {
        $thisUser = new \model\User($_conn, $username, $passwd);

        if ( $thisUser->isAuthenticated() ) {
            // session_start();

            $_SESSION[CMD_USER_ID] = $thisUser->getId();

            header("Status: 301 Moved Permanently");
            header("Location: " . PAG_INDEX);
        }
    }
}
else {
    $isLogout = getHTTPVar(CMD_OPER_TYPE);

    if ($isLogout == OPER_TYPE_LOGOUT) {
        $_SESSION[CMD_USER_ID] = NULL;

        if (session_status() == PHP_SESSION_ACTIVE) {
            session_destroy();
        }

        $isLogged = FALSE;
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <!-- TemplateBeginEditable name="doctitle" -->
        <title>Logon no sistema</title>
    </head>
    <body>
        <p>Informe suas credenciais:
            <form action="<?php echo PAG_LOGIN; ?>" method="post" name="mainFrm" id="mainFrm">
                usu&aacute;rio: <input type="text" name="<?php echo FLD_USR_NAME ?>" id="<?php echo FLD_USR_NAME ?>" />
                senha: <input type="password" name="<?php echo FLD_USR_PASSWD ?>" id="<?php echo FLD_USR_PASSWD ?>" />
                <p><input type="submit" name="_btConfirmar" id="_btConfirmar" value="Login" /></p>
            </form>
        </p>
    </body>
</html>
