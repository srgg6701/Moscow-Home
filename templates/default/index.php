<?php
/**
 * License  GPL
 */
defined('_JEXEC') or die;
$document=JFactory::getDocument();
$tmpl_common = dirname(__FILE__). '/../';
$common_dir = '_common/';
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>">
<head>
<?php require_once $tmpl_common . $common_dir . 'header.php'; ?>
</head>
<body class="no-overflow">
<!--<div id="message">
    <jdoc:include type="modules" name="message" style="xhtml" />
</div>-->
<div id="index">
<?php require_once $tmpl_common . $common_dir . 'nav.php'; ?>
    <main id="content" role="main">
        <jdoc:include type="component" style="none" />
    </main>
<footer class="index">
<?php if ($this->countModules('footer')) : ?>
    <jdoc:include type="modules" name="footer" style="none" />
<?php endif; ?>
    <!--<section>
        <div>Строительство элитной недвижимости с 2004 года</div>
        <div><a id="logo-bottom" href="index.html" class="logo"></a></div>
        <div id="phone-number_bottom">+7 (985) 762-99-66</div>
    </section>-->
</footer>
<?php if ($this->countModules('hidden')) : ?>
    <jdoc:include type="modules" name="hidden" style="none" />
<?php endif; ?></div>
</body>
</html>