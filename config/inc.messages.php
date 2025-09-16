<?php
session_start();
if (isset($_SESSION['msg'])) {
    $tpl->newBlock('msgdiv');
    $tpl->assign('msg', $_SESSION['msg']);
    $tpl->gotoBlock('_ROOT');
}
unset($_SESSION['msg']);
?>