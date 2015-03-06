<script>
    window.onload=function(){
        var loader=document.getElementById('loader-wait'),
            pixContainer=document.getElementById('pix'),
            image = new Image(),
            pix = [<?php
        $dir = dirname(__FILE__).'/../../images/slides/';
        $index=false;
        if($main_page):
            $img_dir="home";
            $index='0';
            else:
                switch($pageclass):
                    case 'design':
                        $index='1';
                        break;
                    case 'decoration':
                        $index='2';
                        break;
                    case 'facade':
                        $index='3';
                        break;
                    case 'engineering-systems':
                        $index='4';
                        break;
                    case 'gallery':

                        break;
                endswitch;
                $img_dir=$pageclass;
        endif;
        if($index!==false) $img_dir=(string)$index."-".$img_dir.'/';
        $dir.=$img_dir; //echo "/*".$dir."*/";
        // Открыть заведомо существующий каталог и начать считывать его содержимое
		if (is_dir($dir)) {
		    $i=0;
			if ($dh = opendir($dir)) {
				while (($file = readdir($dh)) !== false) {
					if ($file!='.'&&$file!='..'&&$file!='_notes') {
					    if($i) echo ", ";
						echo "'$file'";
						$i++;
					}
				}
				closedir($dh);
			}
			$pixWidth=($i*100).'%';
			$pixBlockWidth=(100/$i).'%';
		}
		?>];
        //скорректировать позицию контейнера изображений на ширину одного из них
        pixContainer.style.transform='translateX(-<?php echo $pixBlockWidth;?>)';

        image.onload = function () {
            console.info("%cImage "+pix[0]+" is loaded!",'color:blue');
            jQuery(loader).remove();
            pixContainer.innerHTML='<div class="img" style="background: url(images\/slides\/<?php echo $img_dir;?>' + pix[0] + ') no-repeat center; background-size: cover; width:<?php echo $pixBlockWidth;?>;">';
            for(var i=1, j=pix.length; i<j; i++) {
                pixContainer.innerHTML+='<div class="img" style="background: url(images\/slides\/<?php echo $img_dir;?>' + pix[i] + ') no-repeat center; background-size: cover; width:<?php echo $pixBlockWidth;?>;">';
            }
        };
        image.onerror = function () {
            console.error("Cannot load image "+pix[0]);
            //do something else...
        };
        image.src = 'images\/slides\/<?php echo $img_dir;?>'+pix[0];
        getPixBlock();
    };
    function getPixBlock(){
        var sliderBoxId ='pix', // id блока с картинками
            sliderBox = document.getElementById(sliderBoxId),// блок с картинками
            sliderBoxImgsStr = 'div#'+sliderBoxId+' .img';
            sliderBox.style.width='<?php echo $pixWidth;?>';

        getPixBlock=function() {
            return {
                sliderBox: sliderBox,
                sliderBoxImgsStr: sliderBoxImgsStr
            }
        };
        getPixBlock();
    }
    /**
     * Обработать клик по указателю слайдера
     * @param direction
     */
    function handleSlides(direction){
        var Px=getPixBlock(),
            sliderBox=Px.sliderBox,
            sliderBoxImgsStr=Px.sliderBoxImgsStr,
            order,  // порядок смещения - влево/вправо
            shift_offset, // величина смещения блока с картинками
            iterations_count = 20,//фактическая скорость (чем меньше значение, тем выше) количество итераций смещения блока с картинками
            cntStep = 10;

            //console.log('width: <?php echo $pixWidth;?>');
            //console.group('%cimgOffset: '+imgOffset, 'color: violet');
        handleSlides=function(direction) {
            //console.log('width: <?php echo $pixWidth;?>');
            if (direction == 'left') {
                order = 'first'; // будем выбирать первую картинку
                // назначить увеличенный отступ слева для контейнера картинок:
                shift_offset = -100;
            } else if (direction == 'right') {
                order = 'last'; // будем выбирать последнюю картинку
                // назначить уменьшенный отступ слева для контейнера картинок:
                shift_offset = 100;
            } //console.log('shift_offset = ' + shift_offset);
            var currLeft=0,
                cnt = 0,
                intval = setInterval(function () {
                    currLeft+=shift_offset / iterations_count;
                    sliderBox.style.left = currLeft + '%';
                    /*console.groupCollapsed('124: style.left = ' + sliderBox.style.left);
                        console.log(currLeft+' + ' + shift_offset+ '/' + iterations_count + ' %');
                    console.groupEnd();*/
                    cnt += cntStep;
                    if (cnt == cntStep * iterations_count) {
                        clearInterval(intval);
                        var tImage = document.querySelector(sliderBoxImgsStr + ':' + order + '-child'),
                            newImage = tImage.cloneNode(true); // склонировать крайнюю картинку для последующего перемещения в начало или конец блока
                        jQuery(tImage).remove(); //удалить крайнюю картинку
                        // append/prependTo
                        /*  переместить первую или последнюю картинку соответственно
                         в конец или начало контейнера с изображениями */
                        if (direction == 'left') {
                            // appendChild
                            sliderBox.appendChild(newImage);
                        } else if (direction == 'right') {
                            // insertBefore
                            sliderBox.insertBefore(newImage, document.querySelector(sliderBoxImgsStr));
                        }
                        // вернуть исходный отступ для контейнера с изображениями
                        sliderBox.style.left = 0;
                    }
                }, 10);
        };
        handleSlides(direction);
    }
</script>