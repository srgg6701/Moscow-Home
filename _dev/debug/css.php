<?php
// Тени
$box_shadow = '0 4px 8px rgba(0, 0, 0, 0.5), 0 -14px 20px 2px rgba(0, 0, 0, 0.1) inset';
?>
<style>
    header{
        background-color: lightgoldenrodyellow;
    }
    main{
        background-color: lightcyan;
    }
    footer{
        background-color: lavender;
    }
    <?php echo CONTROLS_ID;?>{
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
    <?php echo CONTROLS_ID;?>:hover {
        opacity: 1;
    }
    <?php echo DEBUG_LINKS_ID;?>{
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
    <?php echo OPACITY_RANGE_ID;?>{
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
    <?php echo SUBSTRATE_WRAPPER_ID;?> {
        bottom: 0;
        margin: auto;
        position: absolute;
        top:<?php echo $controls_height;?>;
        z-index: -1;
    }
    <?php   // установить ширину блока с подложкой
            foreach($substrates as $class=>$substrate):
                $filePath = __DIR__.'/'.IMGS_DIR.'/' . $substrate;
                $sPath = $substrate_path . $substrate;
                if(!file_exists($filePath)) $wrongPaths[]=$sPath;
                ?>
    <?php echo SUBSTRATE_ID;?>.<?php echo $class;?> {
        background: url(<?php echo $sPath;?>) no-repeat;
        background-position-x: -242px;
    }
    <?php   endforeach;?>
    <?php echo SUBSTRATE_ID;?>{
        /*height: 2000px;*/
        margin: 0 auto;
        max-width: 1400px;
        /*overflow: hidden;*/
    }
    <?php echo SUBSTRATE_RANGES_ID;?>{
        display: inline-block;
    }
    .error_warning{
        color:red;
    }
    <?php echo LBL_SBSTR_ID;?>,
    <?php echo SUBSTRATE_RANGES_ID;?>,
    <?php echo DEBUG_LINKS_ID;?>{
        float: left;
    }
    <?php echo LBL_SBSTR_ID;?>,
    <?php echo DEBUG_LINKS_ID;?>{
        margin-top: 5px;
    }
    <?php echo SUBSTRATE_RANGES_ID;?>{
        margin-top: 4px;
        margin-bottom: -22px;
    }
    <?php echo OPACITY_RANGE_ID;?>,
    <?php echo OPACITY_RANGE_CONTENT_ID;?>{
        width: 60px;
    }
    <?php /*echo SUBSTRATE_ID;?> img{
        margin-top: -20px;
    }<?php  */?>
    body {
        position: relative;
        overflow-x: hidden;
    }
<?php
if (isset($_GET['rulers'])):?>
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
<?php
endif;?>
</style>