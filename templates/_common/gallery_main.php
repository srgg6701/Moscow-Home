<script>
    var Pix={};
</script>
<?php // 590х376
$site_dir='images/slides/gallery/';
$dir = dirname(__FILE__).'/../../' . $site_dir;
$sections=array('Шульгино','Никольское','Молоденово','Дом 1','Дом 2','Дом 3');
if (is_dir($dir)) {
    $i=0;
    if ($dh = opendir($dir)) {
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
    Pix['<?php echo $sections[$i];?>']['directory']='<?php echo $file;?>';
    //console.log('dir: <?php echo $file;?>');
    Pix['<?php echo $sections[$i];?>']['images']=[];
</script>
<section>
  <script>
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
  </script>
    <h2 class="header-slim-big"><?php echo $sections[$i];?></h2>
    <div id="slider-<?php echo $gIndex; ?>" class="fit">
        <div id="gallery-pointers-box-<?php echo $gIndex; ?>">
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
                        <div class="indicators" id="indicator-<?php echo $gIndex; ?>">
                        <?php for($k=0;$k<$j;$k++):?>
                            <div<?php if(!$k):?> class="active"<?php endif;?>></div>
                        <?php endfor;?>
                        </div>
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
}?>
<script>
    //console.dir(Pix);
</script>
<?php   require_once 'slider-gallery.php';