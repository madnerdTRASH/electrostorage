<?php 
$tpl->assign('copyYears',date('Y'));
$tpl->assign('executionTime',number_format(microtime(true)-$start,3));
$html = $tpl->draw($view);
?>