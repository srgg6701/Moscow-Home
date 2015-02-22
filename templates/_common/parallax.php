<?php
$div_count=4;
switch($pageclass):
    case 'design':
        $div_count=3;
        $coeffx=array(1.3,0.7,1);
        break;
    case 'decoration':
        $coeffx=array(1,0.7,1,1.2);
        break;
    case 'engineering-systems':
        $coeffx=array(1,1,1,1);
        break;
    case 'facade':
        $div_count=5;
        $coeffx=array(1,1,1,1,1);
        break;
endswitch;
for($i=0;$i<$div_count;$i++):?>
<div class="parallax" id="para<?php echo ($i+1);?>" data-coeff="<?php echo $coeffx[$i];?>"></div>
<?php
endfor;?>