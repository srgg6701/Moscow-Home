<!--
// todo: Нормализовать скрипт; в дальнейшем - сделать вариант на чистом JS
1. Добавить директиву подключения этого файла на тестируемую стр. перед тестируемым блоком (обычно - 1-й уровень внутри BODY)
include_once '[path]/dev.php'; -->
<!--
2. Подключить jQuery, jQueryUI
-->
<?php
ob_start();
$section = $_GET['section'];
if(!$section) $section='default';
/**
 * Настройки подложки: */
$site_name = 'visavi'; 
define("HTTP_BASE_PATH",'http://'.$_SERVER['HTTP_HOST']."/projects/".$site_name.'/'); 
// Идентификатор главного тестируемого блока:
define("MAIN_BLOCK","#page");
// Идентификатор блока с меню тестовых разделов
define("DEBUG_MENU","debug-menu");
// Идентификатор ссылки для управления видимостью меню тестовых разделов
define("DEBUG_LINKS","debug-links");
// Имя директори с изображениями
define("IMGS_DIR","pixel-perfect");
// Изображения для страниц:
$substrates = array(    // класс => имя файла изображения
    // 320
    'home'=>'0.home.png',
    'buildings-premises-design'=>'1.buildings-premises-design.jpg',
    'roofing-facade-work'=>'2.roofing-facade-work.jpg',
    'construction-finishing-work'=>'3.construction-finishing-work.jpg',
    'engineering-systems'=>'4.engineering-systems.jpg',
);
// Путь расположения изображений относительно документа:
$substrate_path = HTTP_BASE_PATH .'_dev/debug/'.IMGS_DIR.'/';
// Тени
$box_shadow = '0 4px 8px rgba(0, 0, 0, 0.5), 0 -14px 20px 2px rgba(0, 0, 0, 0.1) inset';?>
<style>
    /* test block */

    main{
        overflow: auto;
        /*background-color: coral;*/
    <?php
if(isset($_GET['height'])):
            ?>
        /*height: <?php echo $_GET['height'];?>px;*/
<?php
else:
    /*switch($section):
        case 'mobile_default':*/?>/*
        height:375px;
        overflow: hidden;
    <?php
/*        break;
        default:*/?>
        /*height: 1137px;*/
*/<?php
/*        break;
    endswitch;*/
endif;?>
    }
    /*#img_1024_default{
        margin-left:-30px;
    }*/
    /* end of test block*/
    #controls {
    <?php
    $box_shadow_controls="0 -10px 0 10px rgba(0,0,0,0.5)";?>
        background-color: #A1A1A1;
        box-shadow: <?php echo $box_shadow_controls;?>;
        -moz-box-shadow: <?php echo $box_shadow_controls;?>;
        box-sizing: border-box;
        display: table;
        height: <?php $controls_height="36px"; echo $controls_height;?>;
        margin: auto;
        padding: 10px;
        padding-top: 0;
        white-space: nowrap;
    }
    #controls:hover {
        opacity: 1;
    }
	#<?php echo DEBUG_LINKS;?>{
		color: navy;
		cursor:default;
		font-family: verdana;
        font-size: 14px;
		margin-left: 16px;
	}
	.<?php echo DEBUG_MENU;?>{
		display:none;
        padding-top: 26px;
	}
	.<?php echo DEBUG_MENU;?> a{
		display:table;
		font-family:Arial, Helvetica;
		padding:2px 4px;
		text-decoration:none;
	}
	.<?php echo DEBUG_MENU;?> a:hover{
		background-color:lightblue;
	}	
    #opacity-range {
        margin-left: 16px;
    }
    .sbstr {
        background-repeat: no-repeat;
        height: 568px;
        margin: -36px;
        opacity: 0.5;
        position: absolute;
        top: 31px;
        width: 100%;
        z-index: -1
    }
    #substrate-wrapper {
        bottom: 0;
        margin: auto;
        /*max-width: 1100px;*/
        position: absolute;
        /*top: 0;*/
        top:<?php echo $controls_height;?>;
        z-index: -1;
    }
    <?php   // установить ширину блока с подложкой
            foreach($substrates as $class=>$substrate):
                $filePath = __DIR__.'/'.IMGS_DIR.'/' . $substrate;
                $sPath = $substrate_path . $substrate;
                if(!file_exists($filePath)) $wrongPaths[]=$sPath;
                ?>
    #substrate.<?php echo $class;?> {
        background: url(<?php echo $sPath;?>) no-repeat;
        background-position-x: -242px;
    }
    <?php   endforeach;?>
    #substrate {
        height: 2000px;
        margin: 0 auto;
        max-width: 1366px;
        overflow: hidden;
    }
    #substrate-ranges{
        display: inline-block;
    }
    .error_warning{
        color:red;
    }
    #img_1280_default{
        margin-left: -90px;
    }
    #lbl-sbstr,#substrate-ranges,#<?php echo DEBUG_LINKS;?>{
        float: left;
    }
    #lbl-sbstr,#<?php echo DEBUG_LINKS;?>{
        margin-top: 5px;
    }
    #substrate-ranges{
        margin-top: 4px;
        margin-bottom: -22px;
    }
    #opacity-range,
    #opacity-range-content{
        width: 60px;
    }
    #substrate img{
        margin-top: -20px;
    }
</style>
<?php
if(isset($wrongPaths)):
    foreach ($wrongPaths as $wPath) {?>
    <div class="error_warning">
        Не найден файл подложки <?php echo $wPath;?>
    </div>
<?php
    }

endif;
//
if(!defined("MAIN_BLOCK")){?>
    <div class="error_warning"><b>Ошибка!</b>
        <p>Не указан идентификатор контейнера для тестирования (MAIN_BLOCK)</p>
    </div>
<?
}
?>
<div id="controls">
<?php   
$show_substrate=true; // не показывать подложку

if(isset($_GET['sbstr'])&&$_GET['sbstr']=='false')
            $show_substrate=false;
elseif(!$show_substrate&&isset($_GET['sbstr']))
            $show_substrate=true;

if($show_substrate):?>
    <label id="lbl-sbstr" title="Подложка">
        <input type="checkbox" id="sbstr"<?php
	$opacity=(isset($_GET['opa']))? $_GET['opa']:0;
	if($opacity>0):?> checked="checked" <?php endif;?> />
        <img src="_dev/debug/photoshop-substrate.png" />
    </label>
    <div id="substrate-ranges">
        <label title="Прозрачность подложки">
            <input type="range" id="opacity-range" min="0"  max="100" value="<?php echo $opacity*100;?>" />
        </label>
        &nbsp;
        <label title="Прозрачность контента">
            <input type="range" id="opacity-range-content" min="0"  max="100" value="100" />
        </label>
    </div>
    <span id="<?php echo DEBUG_LINKS;?>">Ссылки</span>
<?php   
endif;?>
	<div class="<?php echo DEBUG_MENU;?>">
    	<hr/>
<?php
// построить меню ссылок:
foreach($substrates as $alias=>$image):
?>
	<a href="?section=<?php echo $alias?>"><?php echo $alias;?></a>	
<?php
endforeach;?>
	</div>
</div>
<?php 
if($show_substrate):?>
<div id="substrate-wrapper">
    <div style="opacity: <?php echo $opacity;?>;" id="substrate">
    	<img id="img_<?php echo $section;?>" src="<?php echo HTTP_BASE_PATH?>_dev/debug/<?php echo IMGS_DIR;?>/<?php echo $substrates[$section];?>">
    </div>
</div>
<?php 
endif; ?>
<script>
    $(function(){
        var page = $('<?php echo MAIN_BLOCK;?>'),
            checkbox =$('#sbstr'),
            substrate = $('#substrate'),
            range = $('#opacity-range'),
            tested_content = $('#opacity-range-content'),
            w = $('body').width(),// вычислить отступ слева для подложки
            sbOffset=((w-$(page).width())/ 2)/w * 100 + '%',
            changeOpacity = function(input){
                return parseInt(input.value)/100
            }; //console.log('sbOffset: '+sbOffset);
        $('#substrate-wrapper').css({
            left:sbOffset,
            right:sbOffset
        });
        // переключатель видимости подложки
        $(checkbox).on('click', function(){
            // если подложка скрыта
            if(!$(substrate).is(':visible')||$(substrate).css('opacity')==0){
                /**
                 * установить ползунок прозрачности макета
                 * установить полупрозрачность макета */
                triggerRanges(tested_content,50);
                /**
                 * синхронизировать ползунок подложки
                 * установить полную непрозрачность подложки */
                triggerRanges(range,100);
            }else{ // подложка отображена
                /**
                 * сбросить в ноль ползунок подложки
                 * скрыть подложку */
                triggerRanges(range,0);
            }
        });
        $(range).on('input', function(){
            var cbox=$(checkbox)[0], opa = changeOpacity(this);
            if(opa>0) {
                if(!cbox.checked) cbox.checked=true;
            }else{
                cbox.checked=false;
                /**
                 * синхронизировать ползунок контента (установить в максимум)
                 * установить непрозрачность макета */
                triggerRanges(tested_content,100);
            }
            $(substrate).css({
                display:'block',
                opacity:opa
            });
        });
        $(tested_content).on('input', function(){
            $(page).css('opacity', changeOpacity(this));
        });
		$('#<?php echo DEBUG_LINKS?>').on('click', function(){
			$('.<?php echo DEBUG_MENU;?>').toggle();
		});
        //$('#controls').draggable();
    });
    // установить значение ползунка и прозрачность блока (макет или подложка)
    function triggerRanges(rang,value){
        $(rang).val(value) // синхронизировать ползунок
            .trigger('input'); // установить прозрачность блока
    }
</script>
<?php
//------------------------------------------------
// ЛИНЕЙКА
$test_rulers = 'test_css';
if($test_rulers) {
    if (isset($_GET['rulers'])):?>
<?php
        $rh = 'rulers-horizontal';
        $rv = 'rulers-vertical';
?>
<style>
    body {
        position: relative;
    }
    /* Параметры линеек */
    #<?=$rh?>,
    #<?=$rv?>{
        background-color: orange;
        cursor: move;
        opacity: 0.5;
        position: absolute;
        z-index: 10;
    }
    #<?=$rh?>{
        height: 35px;
        top:35px;
        width: 100%;
    }
    #<?=$rv?>{
        bottom:0;
        left: 35px;
        top:0;
        width: 35px;
    }
</style>
<script>
$(function () {
    var rh = '<?=$rh?>',
        rv = '<?=$rv?>',
        diff = 0,
        attrDr = 'data-dragged',
        horizontal = $('#' + rh),
        vertical = $('#' + rv),
        moveRulers = function (event) {
            var diff, obj = event.currentTarget;
            //console.log(event.currentTarget);
            $(obj).attr(attrDr, 1);
            if (obj.id == rh) {
                diff = event.clientY - parseInt($(obj).css('top'));
                //console.log('Down, diff H:'+diff);
            }
            if (obj.id == rv) {
                diff = event.clientX - parseInt($(obj).css('left'));
                //console.log('Down, diff: V'+diff);
            }
        };
    $('body *').on('selectstart', function () {
        //console.log(event.currentTarget);
        if ($(horizontal).attr(attrDr) || $(vertical).attr(attrDr))
            return false;
    });
    $('body').on('mousemove mouseup', function (event) {
        //console.log('event.type = ' + event.type);
        switch (event.type) {
            case 'mousemove':
                if ($(horizontal).attr(attrDr)) {
                    $(horizontal).css({
                        top: (event.clientY - diff) + window.scrollY + 'px'
                    }); //console.log('clientY:'+event.clientY+'\n');
                }
                if ($(vertical).attr(attrDr)) {
                    $(vertical).css({
                        left: (event.clientX - diff) + 'px'
                    }); //console.log('clientX:'+event.clientX);
                }
                break;
            case 'mouseup':
                $(horizontal).removeAttr(attrDr);
                $(vertical).removeAttr(attrDr);
                break;
        }
    });
    $(horizontal).on('mousedown', function (event) {
        moveRulers(event);
    });
    $(vertical).on('mousedown', function (event) {
        moveRulers(event);
    });
});
</script>
<div id="<?= $rh ?>"></div>
<div id="<?= $rv ?>"></div>
<?php
    endif;
    // Включение/отключение отображения линейки (через сессию):
    if (isset($_GET[$test_rulers])):
        $_SESSION[$test_rulers] = ($_GET[$test_rulers] == '-1') ? NULL : 1;
    endif;?>
<script>
<?php
    // Протестировать подключённые таблицы стилей
    if(isset($_SESSION[$test_rulers])):
    ?>
    var sheet,
        sheets = document.querySelectorAll('link[href][rel="stylesheet"]');
    for (var i in sheets) {
        sheet = sheets[i];
        if (sheet.href)
            console.log(sheet.href.replace('<?php echo HTTP_BASE_PATH?>', ''));
    }
    console.log('%cTo turn these messages off, add the "<?=$test_rulers?>=-1" param to the URL.', 'color: blue;');
    <?php
    else:
    ?>
    console.log('%cCan not get the member of the session. Add the "<?=$test_rulers?>" param to the URL.', 'color: violet;');
<?php
    endif;?>
</script>
<?php
}
//-------------------------------------------------
// КОНЕЦ ЛИНЕЙКИ    ?>
<?php
$content=ob_get_contents();
ob_clean();
echo $content;