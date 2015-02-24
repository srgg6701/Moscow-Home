<?php // 590х376
//mb_internal_encoding("UTF-8");
$dir = dirname(__FILE__).'/../../images/slides/gallery/';
$sections=array('Шульгино','Никольское','Молоденово','Дом 1','Дом 2','Дом 3');
if (is_dir($dir)) {
    $i=0;
    $gIndex=$i+1;
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            //echo "<div>readdir: ".$file.": </div>";
            if ($file!='.'&&$file!='..'){
                $inner_dir = $dir.$file.'/';
                if(is_dir($inner_dir)){
                    //echo "<div>is dir: ".$inner_dir." </div>";
                    $j=0;
                    if($dhr = opendir($inner_dir.'/')){
                        ?>
<section>
    <h2 class="header-slim-big"><?php echo $sections[$i];?></h2>
    <div id="slider-<?php echo $gIndex; ?>" class="fit">
        <div id="gallery-pointers-box-<?php echo $gIndex; ?>">
            <div class="gallery-pointers-aside">
                <aside onclick="handleSlides('left');"></aside>
                <aside onclick="handleSlides('right');"></aside>
            </div>
        </div>
        <div class="img-box" style="display:none;">&nbsp;</div>
        <div class="content-wrapper">
            <div id="preview-container-<?php echo $gIndex; ?>">
                <div id="loaded-content-<?php echo $gIndex; ?>">
                    <div id="images-container-<?php echo $gIndex; ?>">
                        <div id="pix-<?php echo $gIndex; ?>"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="slider-container">
        <div id="slider-mini-<?php echo $gIndex; ?>">
            <div id="gallery-pointers-box-mini-<?php echo $gIndex; ?>">
                <div class="gallery-pointers-aside">
                    <aside onclick="handleSlides('left');"></aside>
                    <aside onclick="handleSlides('right');"></aside>
                </div>
            </div>
            <div class="content-wrapper-mini">
                <div id="preview-container-mini-<?php echo $gIndex; ?>">
                    <div id="loaded-content-mini-<?php echo $gIndex; ?>">
                        <div id="images-container-mini-<?php echo $gIndex; ?>">
                            <div id="pix-mini-<?php echo $gIndex; ?>"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                        <?php
                        while(($realfile = readdir($dhr)) !== false) {
                            if ($realfile != '.' && $realfile != '..') {
                                //if ($j) echo ", ";
                                //echo "<div>$realfile</div>";
                                $j++;
                                if($j>300){
                                    echo "<div>Превышен лимит итераций ($j): </div>";
                                    break;
                                }
                            }
                        }
                        closedir($dhr);
                        //echo "</blockquote></blockquote>";?>
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