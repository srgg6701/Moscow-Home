<script>
    var Pix={};
</script>
<?php // 590х376
/**
ВНИМАНИЕ!
 * Файлы для галереи (http://site_name.[]/gallery) должны размещаться в images/slides/gallery.
 * Последовательность вывода наборов картинок определяется именем директории (по алфавиту)
*/
// получить заголовки секций
$module = JModuleHelper::getModule('mod_gallery_big');
$params = json_decode($module->params);
$sections=explode("\n",$params->headers);
foreach($sections as &$val){
    $val=trim($val);
}
/*echo "<pre>";
var_dump(array($sections));
echo "</pre>";
die();*/
if (is_dir($dir)) {
    $i=0;
    if ($dh = opendir($dir)) {
        //echo "<script>console.log('dir: $dir')</script>";
        while (($file = readdir($dh)) !== false) {
            if ($file!='.'&&$file!='..'){
                //echo "<div>file: ".$file.": </div>";
                $inner_dir = $dir.$file.'/';
                if(is_dir($inner_dir)){
                    $gIndex=$i+1;
                    //echo "<div>is dir: ".$inner_dir." </div>";
                    $j=0;
                    if($dhr = opendir($inner_dir.'/')){
                        ?>
<script>
    Pix['<?php echo $sections[$i];?>']={};
    //console.log('creage object Pix[<?php echo $sections[$i];?>]');
    Pix['<?php echo $sections[$i];?>']['directory']='<?php echo $file;?>';
    Pix['<?php echo $sections[$i];?>']['images']=[];
                    <?php
                        while(($realfile = readdir($dhr)) !== false) {
                            if ($realfile != '.' && $realfile != '..' && $realfile != '_notes') {
                                ?>
    Pix['<?php echo $sections[$i];?>']['images'].push('<?php echo $realfile;?>');
        <?php                   $j++;
                                if($j>300){?>
                                    console.log('Превышен лимит итераций (<?php echo $j;?>)');<?php
                                    break;
                                }
                            }
                        }
                        closedir($dhr);
?>
    //console.log('j: <?php echo $j;?>'); console.groupCollapsed('current, all');console.dir(Pix['<?php echo $sections[$i];?>']);console.dir(Pix);console.groupEnd();
</script>
<section>
    <h2 class="header-slim-big"><?php echo $sections[$i];?></h2>
    <div id="slider-<?php echo $gIndex; ?>" class="fit">
        <div id="gallery-pointers-box-<?php echo $gIndex; ?>" class="big">
            <div class="gallery-pointers-aside" data-pointers="<?php echo $gIndex; ?>">
                <aside class="pointer-left" onclick="handleSlides('left',<?php echo $gIndex; ?>);"></aside>
                <aside class="pointer-right" onclick="handleSlides('right',<?php echo $gIndex; ?>);"></aside>
            </div>
        </div>
        <div class="img-box" style="display:none;">&nbsp;</div>
        <div class="content-wrapper">
            <div id="preview-container-<?php echo $gIndex; ?>">
                <div id="loaded-content-<?php echo $gIndex; ?>">
                    <div id="images-container-<?php echo $gIndex; ?>">
                        <div id="pix-<?php echo $gIndex; ?>"></div>
                        <div id="loader-wait-<?php echo $gIndex; ?>"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="slider-container">
        <div id="slider-mini-<?php echo $gIndex; ?>">
            <div id="gallery-pointers-box-mini-<?php echo $gIndex; ?>">
                <div class="gallery-pointers-aside">
                    <aside onclick="handleSlides('left',<?php echo $gIndex; ?>,'mini');"></aside>
                    <aside onclick="handleSlides('right',<?php echo $gIndex; ?>,'mini');"></aside>
                </div>
            </div>
            <div class="content-wrapper-mini">
                <div id="preview-container-mini-<?php echo $gIndex; ?>">
                    <div id="loaded-content-mini-<?php echo $gIndex; ?>">
                        <div id="images-container-mini-<?php echo $gIndex; ?>">
                            <div id="pix-mini-<?php echo $gIndex; ?>" data-turn="<?php echo $gIndex; ?>"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
                    }
                    $i++;
                }
            }
        }
        closedir($dh);
    }
}

require_once 'slider-gallery.php';