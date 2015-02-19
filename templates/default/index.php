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
<div id="message">
    <jdoc:include type="modules" name="message" style="xhtml" />
</div>
<div id="index">
<?php require_once $tmpl_common . $common_dir . 'nav.php'; ?>
<main>
    <div id="slider" class="fit">
        <ul class="social">
            <li><a href="https://www.facebook.com/moscowhome" title="Facebook"></a></li>
            <li><a href="http://ok.ru/group/53402607354098" title="Одноклассники"></a></li>
            <li><a href="http://vk.com/moscowhomeru" title="ВКонтакте"></a></li>
        </ul>
        <div></div>
        <div id="pointers-box">
            <div id="pointers-aside">
                <aside></aside>
                <aside></aside>
            </div>
        </div>
        <div class="img-box"></div>
        <div id="achievements">
            <div>
                <div id="showcase">
                    <div>
                        <ul>
                            <li>10 лет на рынке</li>
                            <li>сотни реализованных проектов</li>
                            <li>высокое качество работ</li>
                        </ul>
                        <ul>
                            <li>малые и крупные проекты</li>
                            <li>от умеренных пожеланий до масштабных идей</li>
                            <li>от локальных работ до строительства дома</li>
                        </ul>
                        <ul>
                            <li>рекомендации от бизнесменов, политиков, деятелей культуры</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="level1">
        <div id="you-need">
            <p class="header-slim-big">Вам необходимо</p>
            <ul class="you-need">
                <li title="Проектирование и дизайн">
                    <div>
                        <div><a href="design.html">Проектирование и дизайн</a></div>
                    </div>
                </li>
                <li title="Общестроительные и отделочные работы">
                    <div>
                        <div><a href="decoration.html">Общестроительные и отделочные работы</a></div>
                    </div>
                </li>
                <li title="Кровельные и фасадные работы">
                    <div>
                        <div><a href="facade.html">Кровельные и фасадные работы</a></div>
                    </div>
                </li>
                <li title="Инженерные системы">
                    <div>
                        <div><a href="engineering.html">Инженерные системы</a></div>
                    </div>
                </li>
            </ul>
        </div>
        <div id="gallery" class="header-slim-big">Галерея</div>
        <div class="slider-bottom">
            <div class="slides"><a href="#"><img src="static/images_temp/gallery/1.jpg"></a><a href="#"><img src="static/images_temp/gallery/2.jpg"></a><a href="#"><img src="static/images_temp/gallery/3.jpg"></a><a href="#"><img src="static/images_temp/gallery/4.jpg"></a><a href="#"><img src="static/images_temp/gallery/5.jpg"></a><a href="#"><img src="static/images_temp/gallery/6.jpg"></a>
                <aside><a href="#" class="btn">Просмотреть</a></aside>
            </div>
        </div>
    </div>
</main>
<footer class="index">
    <section>
        <div>Строительство элитной недвижимости с 2004 года</div>
        <div><a id="logo-bottom" href="index.html" class="logo"></a></div>
        <div id="phone-number_bottom">+7 (985) 762-99-66</div>
    </section>
</footer>
</div>
</body>
</html>