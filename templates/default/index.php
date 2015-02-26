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
<body class="<?php
if($pageclass):
    echo $pageclass;
else:?>no-overflow<?php endif;?>">
<div id="index">
<?php
$header_class='absolute';
require_once $tmpl_common . $common_dir . 'header-nav.php'; ?>
    <main id="content" role="main">
        <jdoc:include type="component" style="none" />
<?php
    if($pageclass=="gallery"):
        require_once $tmpl_common . $common_dir . 'gallery_main.php';
    endif;?>
    </main>
<footer class="index">
<?php if ($this->countModules('footer')) : ?>
    <jdoc:include type="modules" name="footer" style="none" />
<?php endif; ?>
</footer>
<?php if ($this->countModules('hidden')) : ?>
    <jdoc:include type="modules" name="hidden" style="none" />
<?php endif;?>
</div>
</body>
</html>