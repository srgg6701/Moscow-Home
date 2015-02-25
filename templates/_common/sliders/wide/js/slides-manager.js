/**
 * Обработать клик по указателю слайдера
 * @param direction
 */
function handleSlides(direction){
    var sliderBoxId ='pix', // id блока с картинками
        sliderBox = document.getElementById(sliderBoxId),// блок с картинками
        sliderBoxImgsStr = 'div#'+sliderBoxId+' img', // подстрока выбора селектора картинок в блоке
        order,  // порядок смещения - влево/вправо
        offset_correction = 5, // корректировка позиции блока с картинками (из-за margin'ов)
        imgWidth = document.querySelector('div#images-container img').width,
        shift_offset, // величина смещения блока с картинками
        iterations_count = 30; //количество итераций смещения блока с картинками
    //console.group('%cimgOffset: '+imgOffset, 'color: violet');
    if(direction=='left'){
        order = 'first'; // будем выбирать первую картинку
        // назначить увеличенный отступ слева для контейнера картинок:
        shift_offset = -imgWidth-offset_correction;//810-545; // 265
    }else if(direction=='right'){
        order = 'last'; // будем выбирать последнюю картинку
        // назначить уменьшенный отступ слева для контейнера картинок:
        shift_offset = imgWidth-offset_correction;
    } //console.groupEnd();
    var currLeft=sliderBox.offsetLeft,
        cnt=0;
    var intval=setInterval( function(){
        if(cnt) currLeft=parseInt(sliderBox.style.left);
        sliderBox.style.left=currLeft+shift_offset/iterations_count+'px';
        //console.log('style.left = '+sliderBox.style.left);
        cnt+=10;
        if(cnt==300) {
            clearInterval(intval);
            //console.log('%cstopped!','font-weight: bold');
            var tImage = document.querySelector(sliderBoxImgsStr+':'+order+'-child'),
                newImage = tImage.cloneNode(true); // склонировать крайнюю картинку для последующего перемещения в начало или конец блока
            tImage.remove(); //удалить крайнюю картинку
            // append/prependTo
            /*  переместить первую или последнюю картинку соответственно
             в конец или начало контейнера с изображениями */
            if(direction=='left'){
                // appendChild
                sliderBox.appendChild(newImage);
            }else if(direction=='right'){
                // insertBefore
                sliderBox.insertBefore(newImage,document.querySelector(sliderBoxImgsStr));
            }
            // div#pix
            // вернуть исходный отступ для контейнера с изображениями
            sliderBox.style.left= -imgWidth*2-offset_correction+'px';
        }
    },10);
}