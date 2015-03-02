<?php
$app = JFactory::getApplication();
if(isset($_POST['jform'])){
    require_once 'mail.php';
    $mail_sent=true;
}

$common_path=$this->baseurl . "/templates/" . $common_dir;?>
<link href="<?php echo $common_path;?>css/default.css" rel="stylesheet">
<script src="<?php echo $common_path;?>js/common.js"></script>
<?php   $menu=$app->getMenu();
        $menu_active = $menu->getActive();
        $pageclass = (is_object($menu_active))? $menu_active->params->get('pageclass_sfx'):'';
        $main_page = $menu_active == $menu->getDefault();
        echo "<!--main_page: ".$main_page."-->";
if (!$main_page): // НЕ страница по умолчанию
    if($pageclass!="gallery"&&$pageclass!="print-contacts"):?>
<script src="<?php echo $common_path;?>js/parallax.js"></script>
<?php
    endif;
else:?>
<style>
    html,body{
        height: 100%;
    }
</style>
<?php
endif; ?>
<script src="http://api-maps.yandex.ru/2.0-stable/?load=package.standard&amp;amp;lang=ru-RU"></script>
<script>
ymaps.ready(init);
  var myMap;
  function init(){
      document.getElementById('waiting-map').remove();
      myMap = new ymaps.Map ("map", {
          center: [55.7128,37.0681], zoom: 11
      });
      myPlacemark = new ymaps.Placemark([55.7128,37.0681], {
          hintContent: 'Дома класса люкс. Мы тут!',
          balloonContent: 'Столица России'
      });
      myMap.geoObjects.add(myPlacemark);
<?php   if($pageclass=="print-contacts"):?>
      var intv=setTimeout(function(){
          document.getElementById('wait-printing').style.display='none';
          window.print();
      },2000);
<?php   endif;
        if($main_page):
        ?>
      document.querySelector('.slider-bottom .slides').onclick= function(){
          location.href=location.pathname+'gallery';
      };
<?php   endif;?>
  }
</script>
<?php
if($pageclass!="print-contacts"):
    $site_dir='images/slides/gallery/';
    $dir = dirname(__FILE__).'/../../' . $site_dir;
    if($main_page):
        require_once $tmpl_common . $common_dir . 'slider-home-js.php';
    endif;
endif;