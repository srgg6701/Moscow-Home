<?php $common_path=$this->baseurl . "/templates/" . $common_dir;?>
<title><?php echo JFactory::getDocument()->title;?></title>
<link href="<?php echo $common_path;?>css/default.css" rel="stylesheet">
<script src="<?php echo $common_path;?>js/min/jquery.min.js"></script>
<script src="<?php echo $common_path;?>js/common.js"></script>
<?php   $menu=JFactory::getApplication()->getMenu();
        if (!($menu->getActive() == $menu->getDefault())): // НЕ страница по умолчанию?>
<script src="<?php echo $common_path;?>js/parallax.js"></script>
<?php   else:?>
<style>
    html,body{
        height: 100%;
    }
</style>
<?php   endif;?>
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
  }
</script>
