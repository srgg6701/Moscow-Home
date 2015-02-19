<?php
/**
 * License  GPL
 */
defined('_JEXEC') or die;
$app = JFactory::getApplication();
$leftbar = 1;
$rightbar = 1;
$tmpl_path = $this->baseurl . "/templates/" . $this->template . "/";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>">
<head>
<jdoc:include type="head" />
<link rel="stylesheet" href="<?=$tmpl_path?>css/default.css" type="text/css" />
<?php	
	/* if ($this->countModules('MODULE NAME') == 0) CONTENT */
?>
<script src="<?=$tmpl_path?>js/common.js"></script>
</head>
<body> 
	<div id="message">
	  <jdoc:include type="modules" name="message" style="xhtml" />
	</div>
	<header>
			<?php
			if ($this->params->get('logoType') == 'image') { ?>
			<h1 class="logo">
				<a href="index.php" title="<?php echo $app->getCfg('sitename'); ?>"><span><img src="<?=$tmpl_path?><?php echo $this->template ?>/images/logo.gif" border="0" alt="Logo"></span></a>
			</h1>
			<?php } else { ?>
			<div class="logo-text">
				<h1><a href="index.php" title="<?php echo $this->params->get('logoText'); ?>"><span><?php echo $this->params->get('logoText'); ?></span></a></h1>
				<p class="site-slogan"><?php echo $this->params->get('sloganText');?></p>
			</div>
			<?php } ?>
	</header>
	<main id="content" role="main">
		<jdoc:include type="component" />
	</main>
	<footer>
		<jdoc:include type="modules" name="footer" />
	</footer>
</body>
</html>