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
else:?>
<script>
        //window.print();
</script>
<?php
endif;?>
</div>
</body>
</html>