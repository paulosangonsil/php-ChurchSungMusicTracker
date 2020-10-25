<?php
    set_include_path (get_include_path() . PATH_SEPARATOR .
                        '../view' . PATH_SEPARATOR .
                        'view' . PATH_SEPARATOR .
                        '../model' . PATH_SEPARATOR .
                        'model' . PATH_SEPARATOR .
                        '../controller' . PATH_SEPARATOR .
                        'controller');

    require_once 'database.php';
    require_once 'basectrl.php';
    require_once 'category.php';
    require_once 'singer.php';
    require_once 'song.php';
    require_once 'user.php';
    require_once 'execrec.php';

    const   CMD_OPER_TYPE   = 'oper',
            CMD_REC_ID      = 'strRegId',
            CMD_PAG_ACTUAL  = 'strPagAtual',
            CMD_PAG_OFFSET  = 'pagoffset',
            CMD_CLASS_TYPE  = 'ctype',
            CMD_USER_ID     = 'usrid',

            OPER_TYPE_NEW       = 1,
            OPER_TYPE_EDIT      = 2,
            OPER_TYPE_LIST      = 3,
            OPER_TYPE_SAVE      = 4,
            OPER_TYPE_LOGOUT    = 5,

            CLASS_TYPE_SINGER   = 1,
            CLASS_TYPE_CATEG    = 2,

            SITE_BASE_PATH = '/EscolhaMusica',

            PAG_INDEX       = SITE_BASE_PATH . '/index.php',
            PAG_LOGIN       = SITE_BASE_PATH . '/view/login.php',
            PAG_MNG_BASE    = SITE_BASE_PATH . '/controller/mbase.php', // Category and Singer
            PAG_MNG_SONG    = SITE_BASE_PATH . '/controller/msong.php',
            PAG_MNG_USER    = SITE_BASE_PATH . '/controller/muser.php',
            PAG_MNG_EXEC    = SITE_BASE_PATH . '/controller/mexec.php',
            PAG_LIST_EXEC   = SITE_BASE_PATH . '/view/lexec.php',
            PAG_LIST_BASE   = SITE_BASE_PATH . '/view/lbase.php',
            PAG_STATS_MUS   = SITE_BASE_PATH . '/view/musicstats.php',
            PAG_NAVMENU     = SITE_BASE_PATH . '/view/navmenu.php';

    /**
     * 
     * @param string $strIn
     * @param boolean $treatSlashes
     * @param boolean $treatQuotes
     * @return object|string
     */
    function    clean ($strIn, $treatSlashes = TRUE, $treatQuotes = TRUE) {
        if( empty ($strIn) || ( ! is_string($strIn) ) ) {
            return $strIn;
        }

        $str = trim ($strIn);

        if ( $treatSlashes /*&& get_magic_quotes_gpc ()*/ ) {
            $str = stripslashes ($str);
        }

        $arrToSearchFor = array("\0", "\n", "\r", "\x1a");

        $arrReplace     = array('\\0', '\\n', '\\r', '\\Z');

        if ($treatSlashes) {
            $arrToSearchFor[] = '\\';

            $arrReplace[] = '\\\\';
        }

        if ($treatSlashes) {
            $arrToSearchFor[] = "'";
            $arrToSearchFor[] = '"';

            $arrReplace[] = "\\'";
            $arrReplace[] = '\\"';
        }

        $str = str_replace($arrToSearchFor, $arrReplace, $str);

        return htmlentities ($str/*, ENT_COMPAT | ENT_HTML401 | ENT_SUBSTITUTE, 'ISO-8859-1'/*'cp1252'*/);
    }

    /**
     * @param string $varName
     * @return string
     */
    /*String*/ function getHTTPVar($varName) {
        $mtdRet = NULL;

        for ($cont = 0; $cont < 2; $cont++) {
            $mtdRet = filter_input( ($cont == 0) ? INPUT_POST : INPUT_GET, $varName );

            if ( ! is_null($mtdRet) ) {
                break;
            }
        }

        return clean($mtdRet);
    }

    // Start the login process
    session_start();

    $_conn = new \controller\Database();

    $_idUser = $_SESSION[CMD_USER_ID];

    $isLogged = ( ! empty($_idUser) && ($_idUser > 0) );

    if ($isLogged) {
        /* header("Status: 301 Moved Permanently");
        header("Location: " . PAG_LOGIN); */
    }
