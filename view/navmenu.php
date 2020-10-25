<?php
    require_once 'common.php';

    $linkCateg = '?' . CMD_CLASS_TYPE . '=' . CLASS_TYPE_CATEG;
    $linkSinger = '?' . CMD_CLASS_TYPE . '=' . CLASS_TYPE_SINGER;
?>

<a href="<?php echo PAG_LIST_EXEC; ?>">Listagem de Execu&ccedil;&atilde;o</a>
        <?php if ($isLogged) { ?> (<a href="<?php echo PAG_MNG_EXEC; ?>">Novo</a>) <?php } ?> |
        <a href="<?php echo PAG_STATS_MUS; ?>">Estat&iacute;stica de M&uacute;sicas</a>
        <?php if ($isLogged) { ?> (<a href="<?php echo PAG_MNG_SONG; ?>">Nova</a>) <?php } ?> |
        <a href="<?php echo PAG_LIST_BASE . $linkCateg; ?>">Listagem de Categoria</a>
        <?php if ($isLogged) { ?> (<a href="<?php echo PAG_MNG_BASE . $linkCateg; ?>">Nova</a>) <?php } ?> |
        <a href="<?php echo PAG_LIST_BASE . $linkSinger; ?>">Listagem de Cantor</a>
        <?php if ($isLogged) { ?> (<a href="<?php echo PAG_MNG_BASE . $linkSinger; ?>">Novo</a>) <?php } ?> |
        <?php if (! $isLogged) { ?>
             <a href="<?php echo PAG_LOGIN; ?>">Login</a>
        <?php } else { ?>
             <a href="<?php echo PAG_LOGIN . '?' . CMD_OPER_TYPE . '=' . OPER_TYPE_LOGOUT; ?>">Logout</a>
        <?php } ?>