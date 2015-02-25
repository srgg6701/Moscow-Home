<?php
/**
 * License  GPL
 */
defined('_JEXEC') or die;
$tmpl_common = dirname(__FILE__). '/../';
$common_dir = '_common/';

?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>">
<head>
    <?php require_once $tmpl_common . $common_dir . 'head.php'; ?>
</head>
<body>
<div id="<?php   // @pageclass ─ извлекается в подключаемом файле (head.php)
    echo $pageclass;?>" class="container">
    <?php require_once $tmpl_common . $common_dir . 'header-nav.php'; ?>
    <jdoc:include type="component" style="none" />
    <?php require_once $tmpl_common . $common_dir . 'parallax.php';
          require_once $tmpl_common . $common_dir . 'pop-up_gallery.php';   ?>
</div>
<div id="shell" class="fixed fit hidden">
    <div id="content-box">
        <a href="javascript:void(0)" onclick="return closeParent(event,['shell','curtain']);" class="close">x</a>
    </div>
</div>
<div id="curtain" class="fixed fit hidden"></div>
</body>
</html>