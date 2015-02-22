$(function () {
    var bodyHeight = $('body').height();
    function getTop() {
        var ids = {
            /**
             * Создать набор перемещающихся слоёв.
             * Для каждого указать собственный коэффициент перемещения
             * @coeff   - величина перемещения слоя по вертикали
             * @top     - начальная позиция отступа сверху
             */
            fixed1: {
                coeff: 1,
                top: false,
                distance:0
            },
            fixed2: {
                coeff: 1,
                top: false,
                distance:0
            }
        },
        // вызывается только при инициализации и при изменении размеров окна
        setValues=function(resize){
            // сохранить значения отступов сверху для плавающих слоёв
            for (var id in ids) {
                if(!resize) // только при инициализации
                    ids[id].top = document.getElementById(id).offsetTop;
                // при инициализации и изменении размеров окна
                ids[id].distance = window.innerHeight-ids[id].top;
            }
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
        makeParallax = function (event,calcMax) {
            prlx = getTop();
            //console.dir(prlx);
            for (var layer_id in prlx) {
                if (calcMax) maxScrollTop = getMaxWindowScrollTop();
                //
                var rest = maxScrollTop - $(window).scrollTop(),        // 3060
                    posRatio = 1-rest/maxScrollTop,                     // 1-3060/3280 = 0.07
                    fixedPos = prlx[layer_id].top + $(window).scrollTop(), // "позиции фиксации слоя"  с учётом текущей прокрутки
                    distanceGo = prlx[layer_id].distance * posRatio,    // 0.03
                    newPosTop = (fixedPos + distanceGo) *  prlx[layer_id].coeff;
                    /*console.log('full distance: '+prlx[layer_id].distance);
                    console.log('maxScrollTop: '+maxScrollTop+', scrollTop: '+$(window).scrollTop()+', rest: '+rest);
                    console.log('posRatio: '+posRatio.toFixed(4)+', distanceGo: '+distanceGo.toFixed(4));*/
                document.getElementById(layer_id).style.top = newPosTop + 'px';
                /*console.groupCollapsed('style.top: '+document.getElementById(layer_id).style.top);
                    console.log('maxScrollTop: '+maxScrollTop);
                    console.log('rest: '+rest);
                    console.log('scrollTop: '+$(window).scrollTop());
                    console.groupCollapsed('layer current top: '+document.getElementById(layer_id).style.top);
                        //console.log('widow.scrollTop: '+$(window).scrollTop());
                        console.log('maxScrollTop: '+maxScrollTop);
                        console.log('coeff: '+prlx[layer_id].coeff);
                        console.dir(prlx[layer_id]);
                    console.groupEnd();
                console.groupEnd();*/
            } //console.log('scrollTop: '+$(window).scrollTop()+', offset.top: '+$(fix1).css('top'));
        };
    $(document).on('scroll', function(event){
        makeParallax(event);
    });
    $(window).on('resize', function (event) {
        getTop(true);
        makeParallax(event,true);
    });
});
