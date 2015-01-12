<?php
// Тени
$box_shadow = '0 4px 8px rgba(0, 0, 0, 0.5), 0 -14px 20px 2px rgba(0, 0, 0, 0.1) inset';
?>
<style>
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