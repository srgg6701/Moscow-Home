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
<div id="design" class="container">
<jdoc:include type="component" style="none" />
</div>
</body>
</html>