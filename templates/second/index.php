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
<?php
$app = JFactory::getApplication();
$menu = $app->getMenu()->getActive();
$pageclass = (is_object($menu))? $menu->params->get('pageclass_sfx'):'';?>
<body>
<div id="<?php echo $pageclass;?>" class="container">
    <?php require_once $tmpl_common . $common_dir . 'header-nav.php'; ?>
    <jdoc:include type="component" style="none" />
    <?php require_once $tmpl_common . $common_dir . 'parallax.php'; ?>
</div>
</body>
</html>