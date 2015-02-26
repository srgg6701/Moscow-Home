/**
 * Обработать клик по указателю слайдера
 * @param direction
 */
function handleSlides(direction){
    // получить края и ширину картинки
    var getOffsets = (function(){
        var imsCont =   jQuery('#images-container'), // контейнер с картинками
            imsImgWidth = jQuery('img:first', imsCont).width(),   // одна картинка
        //                  788   -   532   = 256
            wDiff = jQuery(imsCont).width()-imsImgWidth;
        return {
            offs:       wDiff/2, // 128 - отступы от центральной картинки слайдера
            imgWidth:   imsImgWidth // 532 - ширина картинок слайдера
        };
    }());
    var func = 'appendTo',
        sliderBoxId ='pix',
        sliderBox = document.getElementById(sliderBoxId),//
    // отступы от центральной картинки слайдера
        imgOffset = getOffsets.offs, // 128
    // извлечь ширину картинок слайдера (),
        boxOffsetLeft = -(getOffsets.imgWidth*2-imgOffset), // -(532*2 - 128) = 936
        order = 'first';
    //console.group('%cimgOffset: '+imgOffset, 'color: violet');
    if(direction=='left'){
        // назначить увеличенный отступ слева для контейнера картинок:
        imgOffset=-(getOffsets.imgWidth*3-imgOffset); // -(532*3 - 128) = -1468
    }else if(direction=='right'){
        // назначить уменьшенный отступ слева для контейнера картинок:
        imgOffset=-(getOffsets.imgWidth-imgOffset); // -404
        func = 'prependTo';
        order = 'last';
    } //console.groupEnd();
    jQuery(sliderBox).animate( // #pix
        {
            left: imgOffset+'px' // сдвинуть контейнер с картинками
        },  300,
        function () {
            var sliderBoxSelector ='#'+sliderBoxId+' img',
                selName = sliderBoxSelector+':'+order+'-child';
            // append/prependTo
            /*  переместить первую или последнюю картинку соответственно
             в конец или начало контейнера с изображениями */
            jQuery(selName)[func](jQuery(sliderBox));
            // div#pix
            // вернуть исходный отступ для контейнера с изображениями
            jQuery(this).css({
                left: boxOffsetLeft+'px'
            });
        });
}