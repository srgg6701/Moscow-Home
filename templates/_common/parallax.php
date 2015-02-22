<?php   $div_count=($pageclass=='design')? 3:4;
        if($pageclass=='facade') $div_count=5;
        for($i=1;$i<=$div_count;$i++):?>
<div class="parallax" id="para<?php echo $i;?>"></div>
<?php   endfor;?>