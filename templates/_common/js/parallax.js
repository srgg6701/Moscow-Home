jQuery(function () {
    var $=jQuery;
    var bodyHeight = $('body').height();
    function getTop(resize) {
        var ids = {},
        // вызывается только при инициализации и при изменении размеров окна
        setValues=function(resize){
            var el, paras = $('.parallax'); // console.dir(paras);
            // сохранить значения отступов сверху для плавающих слоёв
            paras.each(function(index,element){
                el = 'para'+(parseInt(index)+1);
                ids[el]={};
                if(!resize){ // только при инициализации
                    // начальная позиция отступа сверху
                    ids[el].top = $(element).offset().top;
                    // коэффициент перемещения слоя по вертикали
                    ids[el].coeff = $(element).attr('data-coeff');
                }
                // при инициализации и изменении размеров окна
                ids[el].distance = window.innerHeight-ids[el].top;
            });
        };
        setValues();
        // перегрузить функцию. Далее будем только получать инициализированные значения.
        getTop = function (resize) {
            //console.log('another lunching...');
            if(resize) setValues(true);
            return ids;
        };
    }

    getTop();

    var getMaxWindowScrollTop = function () {
            // получить максимальную позицию прокрутки окна
                    // 4179   - 899     = 3280
            return bodyHeight - window.innerHeight;
        },
        posRatio, // соотношение текущей прокрутки окна к максимальной
        maxScrollTop = getMaxWindowScrollTop(),
        prlx,
        PLayer,
        sumTop,
        makeParallax = function (event,calcMax) {
            // если стилями не отменена видимость "летающих элементов"
            if($('.parallax:visible').size()){
                // Если calcMax передаётся, инициализированные параметры объекта переопределяются
                prlx = getTop(calcMax); // console.dir(prlx);
                var test=false;
                for (var layer_id in prlx) {
                    PLayer =  document.getElementById(layer_id);
                    if(!PLayer) { console.log('No PLayer(id='+layer_id+'), prlx: '); console.dir(prlx); break; }
                    sumTop=$(PLayer).offset().top+$(window).scrollTop();
                    if(test){
                        if(sumTop-maxScrollTop<=0){
                            console.groupCollapsed('%c'+PLayer.id,'color: brown');
                            //console.log('rest: '+(maxScrollTop - $(window).scrollTop()));
                            console.log('%cscrollTop: '+$(window).scrollTop(),'color: green');
                            console.log('%cmaxScrollTop: '+maxScrollTop,'color: violet');
                            console.log('PLayer.offset.top: '+$(PLayer).offset().top);
                            console.log('%cPLayer.offset.top + window.scrollTop: '+sumTop,'color: blue');
                            console.log('%cdiff: '+(sumTop-maxScrollTop),'color: orange');
                            //console.log('bodyHeight: '+bodyHeight);
                            console.groupEnd();
                        }
                    }

                    if(sumTop-maxScrollTop>0||prlx[layer_id].top<window.innerHeight){ // 899
                        if (calcMax) maxScrollTop = getMaxWindowScrollTop();
                        //
                        var rest = maxScrollTop - $(window).scrollTop(),        // 3060
                            posRatio = 1-rest/maxScrollTop,                     // 1-3060/3280 = 0.07
                            fixedPos = prlx[layer_id].top + $(window).scrollTop(), // "позиции фиксации слоя"  с учётом текущей прокрутки
                            distanceGo = prlx[layer_id].distance * posRatio,    // 0.03
                            newPosTop = (fixedPos + distanceGo) *  prlx[layer_id].coeff;

                        PLayer.style.top = newPosTop + 'px';

                        if(test){
                            console.groupCollapsed(layer_id+', style.top: '+document.getElementById(layer_id).style.top);
                            console.log('%cPLayer.offset.top + window.scrollTop: '+sumTop,'color: blue');
                            console.log('posRatio: '+posRatio.toFixed(4)+', distanceGo: '+distanceGo.toFixed(4));
                            console.log('%cdiff: '+(sumTop-maxScrollTop),'color: orange');
                            //console.log('full distance: '+prlx[layer_id].distance);
                            //console.log('maxScrollTop: '+maxScrollTop);
                            console.groupCollapsed('layer current top: '+PLayer.style.top);
                            //console.log('widow.scrollTop: '+$(window).scrollTop());
                            console.log('maxScrollTop: '+maxScrollTop);
                            console.log('coeff: '+prlx[layer_id].coeff);
                            //console.dir(prlx[layer_id]);
                            console.groupEnd();
                            console.groupEnd();
                        }
                    }
                } //console.log('scrollTop: '+$(window).scrollTop()+', offset.top: '+$(fix1).css('top'));
            }
        };
    $(document).on('scroll', function(event){
        makeParallax(event);
    });
    $(window).on('resize', function (event) {
        makeParallax(event,true);
    });
});
