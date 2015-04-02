<script>
var imgBlockWidth = 590,// синхронизировать с $img-gallery-main-width в slider.scss
    imgBlockPrevWidth = 107,
    prevMargin =21;
window.onload=function(){
    var gIndex= 0,
        pixContainer,
        pixContainerMini; // генерация индикаторов закомментирована в templates/_common/gallery_main.php
    //console.dir(Pix);
    //console.groupCollapsed('Pix');
    for(var section_name in Pix){   //console.log(section_name); // Шульгино, Молоденово ...
        gIndex++; //console.dir(Pix[section_name]);
        <?php /*
        Дом 3:  Object
                    directory:  images/slides/gallery/6-home
                    images:     Array[4]
                                    0: "IMG_6786.jpg"
                                    1: "IMG_6787.jpg"
                                    2: "IMG_6799.jpg"
                                    3: "IMG_6804.jpg"   */ ?>
        pixContainer=document.getElementById('pix-'+gIndex);
        pixContainerMini=document.getElementById('pix-mini-'+gIndex);
        // установить ширину контейнера изображений
        pixContainer.style.width=imgBlockWidth*Pix[section_name]['images'].length+'px';
        pixContainerMini.style.width=(imgBlockPrevWidth+prevMargin)*Pix[section_name]['images'].length+'px';
        // не слишком ли мало картинок?
        if(Pix[section_name]['images'].length<3)
            pixContainer.setAttribute('data-value',Pix[section_name]['images'].length);
        pixContainer.innerHTML=pixContainerMini.innerHTML=''; //indicators.innerHTML=
        //var i=0;
        //console.log('images.length: '+Pix[section_name]['images'].length);
        for(var index in Pix[section_name]['images']){

            pixContainer.innerHTML+='<div class="img" style="background: url(\'images/slides/gallery/'+Pix[section_name]['directory']+'/'+Pix[section_name]['images'][index] + '\');" data-index="'+index+'">';
            var ldr;
            if(ldr=document.getElementById('loader-wait-'+gIndex)){
                //console.log('удалить id: '+'loader-wait-'+gIndex);
                jQuery(ldr).remove();
            }
            pixContainerMini.innerHTML+='<div class="img-mini" style="background: url(\'images/slides/gallery/'+Pix[section_name]['directory']+'/'+Pix[section_name]['images'][index] + '\');" data-index="'+index+'">';
            //i++;
        }
        if(Pix[section_name]['images'].length<7){
            pixContainerMini.className='tiny cols'+Pix[section_name]['images'].length;

        }
        getPixBlock(gIndex);
    }
    //console.groupEnd();
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
/**
 *
 */
function getPixBlock(gIndex,mini){
    var sliderBoxId,        // id блока с картинками
        sliderBox,          // блок с картинками
        sliderBoxImgsStr,   // селектор выбора блока с картинками
        // получить параметры контейнера
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
 * Параметры смещения
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
        var $=jQuery,
            Px=getPixBlock(gIndex,mini),
            sliderBox=Px.sliderBox,
            sliderBoxImgsStr=Px.sliderBoxImgsStr,
            shift_offset = (mini)? imgBlockPrevWidth+prevMargin:imgBlockWidth,
            currLeft=0,
            cnt = 0;
        order = 'last'; //console.log('direction: '+direction);
        if (direction == 'left') {
            order = 'first'; // будем выбирать первую картинку
            // назначить увеличенный отступ слева для контейнера картинок:
            shift_offset*=-1;
        }   // генерация индикаторов закомментирована в templates/_common/gallery_main.php
        var intval = setInterval(function () {
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
                    if(mini) sliderBoxImgsStr+='-mini';
                    //console.log('querySelector: '+sliderBoxImgsStr + ':' + order + '-child');
                    if(tImage=$(sliderBoxImgsStr + ':' + order + '-child')) {
                        newImage = tImage.clone(true); // склонировать крайнюю картинку для последующего перемещения в начало или конец блока
                        $(tImage).remove(); //удалить крайнюю картинку
                        // append/prependTo
                        /*  переместить первую или последнюю картинку соответственно
                         в конец или начало контейнера с изображениями */
                        //console.log(sliderBox);
                        if (direction == 'left') {
                            // appendChild
                            $(sliderBox).append(newImage);
                        } else if (direction == 'right') {
                            // insertBefore
                            $(sliderBox).prepend(newImage);
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