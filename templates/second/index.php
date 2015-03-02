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
    <jdoc:include type="head" />
    <?php require_once $tmpl_common . $common_dir . 'head.php'; ?>
</head>
<body>
<?php   require_once $tmpl_common . $common_dir . 'mail_informer.php';?>
<div id="<?php   // @pageclass ─ извлекается в подключаемом файле (head.php)
    echo $pageclass;?>" class="container">
    <?php
if($pageclass!="print-contacts"):
    require_once $tmpl_common . $common_dir . 'header-nav.php';
endif;?>
    <jdoc:include type="component" style="none" />
<?php
if($pageclass!="print-contacts"):
    require_once $tmpl_common . $common_dir . 'parallax.php';
endif;?>
</div>
<?php
if($pageclass=="design"):?>
    <div id="partners-iframe" style="display: none;">
        <div id="gallery" class="header-slim-big">Проекты партнеров</div>
        <iframe style="height: 2800px;" src="http://frame.plans24.ru/s1171/" height="400" width="100%" frameborder="0" scrolling="no"></iframe>
    </div>
<script>
    jQuery(function(){
        var $=jQuery,
            iframe=$('#partners-iframe');
        $(iframe).show();
        $('#work-examples').after(iframe);
    });
</script>
<?php /* <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script><script type="text/javascript" src="iframe.js"></script> */
endif;?>
</body>
</html>