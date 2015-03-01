<script>
    var imgBlockWidth = 590,// синхронизировать с $img-gallery-main-width в slider.scss
        imgBlockPrevWidth = 107,
        prevMargin =21;
    window.onload=function(){
        var gIndex= 0,
            pixContainer,
            pixContainerMini/*, indicators*/; // генерация индикаторов закомментирована в templates/_common/gallery_main.php
        for(var section_name in Pix){   //console.log(section_name); // Шульгино, Молоденово ...
            gIndex++; //console.dir(gIndex,Pix[section_name]);
            <?php /*
            Дом 3:  Object
                        directory:  images/slides/gallery/6-home
                        images:     Array[4]
                                        0: "IMG_6786.jpg"
                                        1: "IMG_6787.jpg"
                                        2: "IMG_6799.jpg"
                                        3: "IMG_6804.jpg"   */ ?>
            //loader=document.getElementById('loader-wait-'+gIndex);
            pixContainer=document.getElementById('pix-'+gIndex);
            // indicators=getIndicator(gIndex); // генерация индикаторов закомментирована в templates/_common/gallery_main.php
            pixContainerMini=document.getElementById('pix-mini-'+gIndex);
            // установить ширину контейнера изображений
            pixContainer.style.width=imgBlockWidth*Pix[section_name]['images'].length+'px';
            pixContainerMini.style.width=(imgBlockPrevWidth+prevMargin)*Pix[section_name]['images'].length+'px';
            // не слишком ли мало картинок?
            if(Pix[section_name]['images'].length<3)
                pixContainer.setAttribute('data-value',Pix[section_name]['images'].length);
            pixContainer.innerHTML=pixContainerMini.innerHTML=''; //indicators.innerHTML=
            //var i=0;
            for(var index in Pix[section_name]['images']){
                /*if(i){
                    indicators.innerHTML+='<div></div>';
                }else{
                    indicators.innerHTML += '<div class="active"></div>';
                    //console.log('has active: '+indicators);
                }*/
                pixContainer.innerHTML+='<div class="img" style="background: url(\'images/slides/gallery/'+Pix[section_name]['directory']+'/'+Pix[section_name]['images'][index] + '\');" data-index="'+index+'">';
                var ldr;
                if(ldr=document.getElementById('loader-wait-'+gIndex)){
                    //console.log('удалить id: '+'loader-wait-'+gIndex);
                    ldr.remove();
                }
                pixContainerMini.innerHTML+='<div class="img-mini" style="background: url(\'images/slides/gallery/'+Pix[section_name]['directory']+'/'+Pix[section_name]['images'][index] + '\');" data-index="'+index+'">';
                //i++;
            }
            if(Pix[section_name]['images'].length<7){
                pixContainerMini.className='tiny';
            }
            getPixBlock(gIndex);
        }
        jQuery('.img-mini').on('click', function(){
            var element=this,
                dataIndex=jQuery(this).attr('data-index'),
                dataTurn = jQuery(this).parent().attr('data-turn'),
                bigParallelDataIndex = jQuery('#pix-'+dataTurn+' >div').eq(1).attr('data-index'),
                indecesDiff = dataIndex-bigParallelDataIndex,
                direction =(indecesDiff>0)? 'left':'right',
                repetition = Math.abs(indecesDiff);

            var iterationParams = getIterationParams(),
                iterations_count =iterationParams.iterations_count,//фактическая скорость (чем меньше значение, тем выше) количество итераций смещения блока с картинками
                cntStep = iterationParams.cntStep,
                duration = iterationParams.duration,
                cnt = 0,
                Px=getPixBlock(dataTurn),
                sliderBox=Px.sliderBox,
                repeatLimit = cntStep * iterations_count;
                // если есть разница
                if(indecesDiff){
                    //console.log('repetition: '+repetition+', direction: '+direction+', indecesDiff: '+indecesDiff+', dataIndex: '+dataIndex+', bigParallelDataIndex: '+bigParallelDataIndex);
                    handleSlides(direction,dataTurn);
                    //jQuery('[data-pointers="'+dataTurn+'"] aside.pointer-'+direction).trigger('click');
                    repetition--;
                    if(repetition){
                        //console.log('repetition start: '+repetition);
                        var doIt=setInterval(function(){
                            cnt += cntStep; //console.dir('cnt: '+cnt+', repeatLimit: '+repeatLimit);
                            if (cnt >= repeatLimit){
                                if(parseInt(sliderBox.style.left) == 0){
                                    repetition--;
                                    if(repetition>=0) {
                                        handleSlides(direction,dataTurn);
                                        //jQuery('[data-pointers="'+dataTurn+'"] aside.pointer-'+direction).trigger('click');
                                    }
                                    cnt=0;
                                } //else console.log('left: '+sliderBox.style.left);
                                //console.log('repetition: '+repetition);
                            }
                            if(!repetition) {
                                //var tIndex=jQuery(element).index(),
                                    //indicators=getIndicator(dataTurn);
                                //console.log('dataTurn: '+dataTurn+', tIndex: '+tIndex);
                                //jQuery('div',indicators).eq(tIndex).addClass('active');
                                //console.dir(jQuery('div',indicators).eq(tIndex));
                                clearInterval(doIt);
                            }
                            if(cnt>1000){
                                console.log('превышен лимит итераций');
                                clearInterval(doIt);
                            }
                        },duration);
                    }
                }
        });
    };

function getPixBlock(gIndex,mini){
    var sliderBoxId,        // id блока с картинками
        sliderBox,          // блок с картинками
        sliderBoxImgsStr,   // селектор выбора блока с картинками
        getParams=function(gIndex,mini){
            sliderBoxId =(mini)? 'pix-mini-'+gIndex:'pix-'+gIndex;
            sliderBox = document.getElementById(sliderBoxId);
            sliderBoxImgsStr = 'div#'+sliderBoxId+' .img';
        };

    getPixBlock=function(gIndex,mini) {
        if(gIndex) getParams(gIndex,mini);
        //console.log('gIndex: '+gIndex);
        //console.log(sliderBox, sliderBoxImgsStr);
        return {
            sliderBox: sliderBox,
            sliderBoxImgsStr: sliderBoxImgsStr
        }
    };
    getPixBlock(gIndex,mini);
}
/**
 *
 */
function getIterationParams(){
    return{
        iterations_count:20,
        cntStep:10,
        duration:10
    }
}
/**
 * Обработать клик по указателю слайдера
 * @param direction
 */
function handleSlides(direction,gIndex,mini){
    var order,  // порядок смещения - влево/вправо
        shift_offset, // величина смещения блока с картинками
        iterationParams = getIterationParams(),
        iterations_count =iterationParams.iterations_count,//фактическая скорость (чем меньше значение, тем выше) количество итераций смещения блока с картинками
        cntStep = iterationParams.cntStep,
        duration = iterationParams.duration;

    //console.log('width: <?php //echo jQuerypixWidth;?>');
    //console.group('%cimgOffset: '+imgOffset, 'color: violet');
    handleSlides=function(direction,gIndex,mini) {
        if(document.getElementById('pix-'+gIndex).childNodes.length==1){
            alert('Показано единственное изображение');
            //console.dir(document.querySelectorAll('#images-container-'+gIndex+' [id^="pix-"]'));
            return false;
        }
        var Px=getPixBlock(gIndex,mini),
            sliderBox=Px.sliderBox,
            sliderBoxImgsStr=Px.sliderBoxImgsStr,
            /*  indicators=getIndicator(gIndex),
                indicator=jQuery('.active', indicators);
                if(!mini) jQuery('div.active',indicators).removeClass('active'); */ // генерация индикаторов закомментирована в templates/_common/gallery_main.php
            //console.log('active indicator: '+indicator);
        shift_offset = (mini)? imgBlockPrevWidth+prevMargin:imgBlockWidth;
        order = 'last'; //console.log('direction: '+direction);
        if (direction == 'left') {
            order = 'first'; // будем выбирать первую картинку
            // назначить увеличенный отступ слева для контейнера картинок:
            shift_offset*=-1;
            /*if(!mini){ // генерация индикаторов закомментирована в templates/_common/gallery_main.php
                if(jQuery(indicator).prev().size()) {
                    jQuery(indicator).prev().addClass('active');
                    //console.log('prev: ');console.dir(jQuery(indicator).prev());
                }else {
                    jQuery('>div',indicators).eq(-1).addClass('active');
                    //console.log('next: ');console.dir(jQuery(indicators));
                }
            }*/
        }/*else{
            if(!mini){
                if(jQuery(indicator).next().size()) {
                    jQuery(indicator).next().addClass('active');
                    //console.log('next: ');console.dir(jQuery(indicator).next());
                }else {
                    jQuery('>div',indicators).eq(0).addClass('active');
                    //console.log('prev: ');console.dir(jQuery(indicators));
                }
            }
        }*/ // генерация индикаторов закомментирована в templates/_common/gallery_main.php
        var currLeft=0,
            cnt = 0,
            intval = setInterval(function () {
                currLeft+=shift_offset / iterations_count;
                sliderBox.style.left = currLeft + 'px';
                //console.log('sliderBox.id: '+sliderBox.id);
                //console.dir(sliderBox);
                /*console.groupCollapsed('101: style.left = ' + sliderBox.style.left);
                    console.log(currLeft+' + ' + shift_offset+ '/' + iterations_count + ' px');
                    console.log(sliderBox);
                console.groupEnd();*/
                cnt += cntStep; // +=10 каждые 10 млсек, пока не станет 200; 20*10 млсек = 0.2 сек
                if (cnt == cntStep * iterations_count) { // 10*20
                    clearInterval(intval);
                    var tImage, newImage;
                    if(tImage=document.querySelector(sliderBoxImgsStr + ':' + order + '-child')) {
                        newImage = tImage.cloneNode(true); // склонировать крайнюю картинку для последующего перемещения в начало или конец блока
                        tImage.remove(); //удалить крайнюю картинку
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
                }
            }, duration); // 10
    };
    handleSlides(direction,gIndex,mini);
}
function getIndicator(gIndex){
    return document.getElementById('indicator-'+gIndex);
}
</script>