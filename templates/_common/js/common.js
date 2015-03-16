jQuery(function(){
    var $=jQuery,
        imageBg = new Image(),
        selectors='[id^="diigo"], script[src*="metabar"]',
        i=0,        // счётчик итераций
        limit=25, //, // лимит итераций
        /**
         * Перегруппировать меню при мобильных разрешениях
         */
        rearrangeMobileElements=function(){
            var menuBlock=$('header > section.menu >section:first-child'),
                pseudolinks=$('aside',menuBlock),
                menu_container_class= '.menu-container',
                texts=$(menu_container_class + ' > section',menuBlock),
                mobileSectionsLength=$('section',pseudolinks).size(),
                aPrint = $('#goprint');
            //console.log('rearrangeMobileElements, width: '+$('body').width()+', mobileSectionsLength: '+mobileSectionsLength);
            if(checkResolutionMobile()){
                //console.log('checkResolutionMobile OK');
                if(!mobileSectionsLength){ // меню не модифицировано
                    moveSubmenusTexts(pseudolinks,texts,true);
                    // Переместить кнопку "Распечатать адрес"
                    movePrintButton(aPrint,true);
                }
            }else if(mobileSectionsLength){ // меню модифицировано
                    moveSubmenusTexts(pseudolinks,menu_container_class);
                    // Переместить кнопку "Распечатать адрес"
                    movePrintButton(aPrint);
            }
        },
        intv=setInterval(function(){ // процедура удаления
            //console.log('diigos: '+$(selectors).size());
            if($(selectors).size()){
                $(selectors).remove();
                //console.log('removing...');
            }
            i++;
            if(i>limit) {
                clearInterval(intv);
                console.log('%cвыполнено максимальное ('+limit+') количество итераций...','color: orange');
            }
        },200),
        // ОБРАБОТАТЬ ВЫПАДАЮЩЕЕ МЕНЮ
        //---------------------------------
        top_menu=$('#top-menu'),
        dd_menus=$('nav a[href="#"]'),              // псевдоссылки
        submenu_items=$('header aside >div'),       // внутренние "пункты меню"
        menus_container=getMenusContainer();        // контейнер с блоками меню
        // управление меню при событии его контейнера
        menus_container.on('mouseenter click mouseleave', function(event){
            setVisibilityState(event);
        });

    //-----------------------------------------
    rearrangeMobileElements();
    $(window).on('resize',function(){
        rearrangeMobileElements();
        /**
         * todo: по-хорошему нужно сохранять координаты последней карты
         * и передавать их создаваемой  */
        createYMap();
        $('.ymaps-map:not(:last)').hide();
    });

    imageBg.src=location.origin+'/templates/_common/images/backgrounds/tile-contacts.png';

    var frameClick=false, ifr;
    var intrv=setInterval(function(){
        if(ifr=document.getElementById('partner-iframe')){
            //
            $(ifr).on('load', function(){
                //console.log('%ciFrame is loaded','color:brown'); console.log('%cframeClick: '+frameClick,'font-weight:bold');
                //if(frameClick) console.log('%ciFrame is reloaded!','color:violet');
            }).on('click', function(){
                //console.log('%cframeClick is: '+frameClick,'color:red');
                frameClick=true;
            });
            clearInterval(intrv);
        }
    }, 100);
    //-----------------------------------------
    // todo: удалить после тестирования
    $(dd_menus).on('click', function(){
        $(getInnerMenus()).hide();
        $(getMenusContainer()).hide();
    });

    /*$('.gallery #content .header-slim-big').on('click mouseenter mouseleave', function(event){
        console.log('event type: '+event.type);
        var bg=(//event.type=='touchstart' ||
                event.type=='mouseenter'||
                event.type=='click' //||event.type=='vmouseover'
            )? 'yellow':'transparent';
        $(this).css('background-color',bg);
    });*/

    /**
     * Скрыть все выпадающие меню
     */
    $('nav a:not([href="#"])').on('mouseenter click',hideAll);
    // Управлять выпадающими меню
    dd_menus.on('mouseenter click mouseleave', function(event){
        if(event.type=='click') {
            event.preventDefault(); //console.log('event: '+event.type+', checkResolutionMobile: '+checkResolutionMobile());
        }
        var menu_to_show_index,
            // Динамический заголовок анктивного меню
            menus_subheader_mobile = $('#menus-subheader-mobile');
        // Отобразить вып. меню и его родительский блок
        if(event.type=='mouseenter'||event.type=='click'){
            //console.log('is: '+(dd_menus.last().is(this)));
            //console.dir(dd_menus.last()[0]);console.dir(this);
            if(checkResolutionMobile()){
                top_menu.slideUp(200);
                if(dd_menus.last().is(this))
                    menus_subheader_mobile.hide();
                else // подставить текст заголовка
                    menus_subheader_mobile.show().text(this.innerText);
            }
            menu_to_show_index=dd_menus.index(this);
        }
        // установить состояние видимости
        setVisibilityState(event,menu_to_show_index);
    });
    // ... мобильная версия, сэндвич, показать/скрыть меню
    $('#sandwich-menu').on('click', function(){
        top_menu.slideToggle(200);
    });
    // Обработать блоки выпадающего меню // aside >div
    submenu_items.on('mouseenter click mouseleave', function(event){
        var bgClass='bgActiveCarrot';
        //
        setVisible(this);
        if(event.type=='mouseenter'||event.type=='click'){//click
            $(submenu_items).removeClass(bgClass); //alert('got it!');
            $(this).addClass(bgClass);
        }
        if(event.type=='mouseleave'){ //console.log('mouseleave');
            //index=$(this).parent().find('div.'+bgClass).index();
            setVisible(this);
        }
    });
    // Обработать поле загрузки файла
    $('input[name="attach-file"]').on('change', function(){
        var filepath=$(this).val(),
            sep=(filepath.indexOf('\\')!=-1)? '\\':'\/';
        $('#attachment-name').html(filepath.split(sep).pop());
        handleAskFormSection(true); // set attr data-state to 1
    });
    // Открыть подменю "Консультация" кликом по кнопке "Перезвоните мне"
    $('.bg-recall').on('click', function(){
        $('#btn-consult').trigger('mouseenter');
        handleInputs('hide');
    });
    // показать/скрыть текст под кнопкой
    $('.btn-more').on('click', function(){
        $(this).next('div.hidden').slideToggle(200);
    });
    // Запустить выбор файла
    $('.attach-file').on('click',function(){
        $('input[name="attach-file"]').trigger('click');
    });
});
/**
 * Проверить порог разрешения
 * @returns {boolean}
 */
function checkResolutionMobile(){
    return jQuery('body').width()<=1024;
}
/**
 * Спрятать родительский блок кликом по кнопке/ссылке "закрыть"
 * @param event
 * @param layers
 */
function closeParent(event,layers){
    console.log('closeParent');
    //console.dir(jQuery(event.currentTarget).parent());
    var $=jQuery,parent=$(event.currentTarget).parent();
    $(parent).fadeOut(400, function(){
        //console.log('closing...');
        //if($(parent).is(':visible')) console.log('%cis visible!','color: red');
        //else console.dir($(parent));
        if(layers){
            for(var i= 0, j=layers.length; i<j; i++){
                jQuery('#'+layers[i]).fadeOut(200);
            }
        }else return;
    });
}
/**
 * Получить контейнер с меню
 * @returns {*|jQuery|HTMLElement}
 */
function getMenusContainer(){
    return jQuery('header >section');
}
/**
 * Получить внутренние блоки контейнера (все вып. меню)
 * @returns {*|jQuery|HTMLElement}
 */
function getInnerMenus(){
    // header >section >section
    return jQuery('>section',getMenusContainer()); // блоки с меню
}
/**
 * Скрыть все меню
 */
function hideAll(){
    jQuery(getInnerMenus()).hide();
    jQuery(getMenusContainer()).hide(); // скрыть контейнер с меню
    handleInputs('show');
}
/**
 * Получить/обработать данные секции с формой отправки, чтобы знать, прятать её или нет
 * @param set_data
 * @returns {*}
 */
function handleAskFormSection(set_data){
    //console.log('%cset_data value: ['+set_data+']','color:blue; font-style:italic');
    var $=jQuery,
        dataStat ='data-state',
        inp=$('header>section>section:last-child');
    if (set_data===false) {
        $(inp).removeAttr(dataStat);
        //console.log('%c'+dataStat+' (removed): '+$(inp).attr(dataStat),'color: brown');
    }else if(set_data){
        if(set_data=='check'){
            //console.log('%c'+dataStat+' checking: '+$(inp).attr(dataStat),'color: green');
            return $(inp).attr(dataStat);
        }else {
            $(inp).attr(dataStat,1);
            console.log('%c'+dataStat+' (set): '+$(inp).attr(dataStat),'color: goldenrod');
        }
    }
    return inp;
}
/**
 *
 * @param state
 */
function handleInputs(state){
    var email_input = document.querySelector('input[name*="email"]'),
        telephone=document.querySelector('input[name*="telephone"]').parentNode;
    if(state=='hide'){
        telephone.style.width='100%';
        email_input.disabled=true;
    }else{
        telephone.style.width='50%';
        email_input.disabled=false;
    }
    jQuery(email_input.parentNode)[state]();
}
/**
 * Управлять видимостью контейнера с меню
 */
function setVisibilityState(event,menu_to_show_index){
    var active_link,            // Состояние видимости "ссылок"
        visibility_container,   // Состояние видимсти "контейнера меню"
        menu_index,             // Индекс таргет-меню
        $=jQuery;
    // перегрузить функцию:
    setVisibilityState=function (event,menu_to_show_index) {
        if(!isNaN(parseInt(menu_to_show_index)))
            menu_index=menu_to_show_index;
        var target_obj=event.currentTarget.tagName.toLowerCase(),
            action=event.type,
            active='active',
            visible,
            askBlock=handleAskFormSection(); //console.log('%caction: '+action,'color:navy'); //console.log('%ctarget: '+target_obj,'color:green');
        //
        if(action=='mouseenter'||action=='click'){
            if(target_obj=='a') {
                active_link=active;
                visibility_container=true;
            }else{
                active_link=true;
                visibility_container=active;
                if($(askBlock).index()==menu_index){
                    handleAskFormSection(false); // remove data-state
                }
            }
            //console.log('%cvisibility_container: '+visibility_container,'color:violet');
            //console.log('%cactive_link: '+active_link,'color:blue');
        }else
        if((action=='mouseleave') && (visibility_container!=active||active_link!=active)){ // уходим с объекта
            if($(askBlock).index()==menu_index){ // если блок с формой обратной связи
                if(handleAskFormSection('check')){ // проверить data-state
                    visible=true;
                }
            }
            if(!visible){
                visibility_container=false;
                active_link=false;
            }
            //console.log('%cvisibility_container: '+visibility_container,'color:violet');
            //console.log('%cactive_link: '+active_link,'color:blue');
        }
        var visibility_stat=(active_link || visibility_container);
        $(getInnerMenus()).hide(); // header >section >section
        if(visibility_stat){
            $(getMenusContainer()).show(); // отобразить контейнер с меню
            $(getInnerMenus()) // header >section >section
                .eq(menu_index).show();
        }else{
            hideAll();
        }
    };
    setVisibilityState(event,menu_to_show_index);
}/**
 * Управлять видимостью блоков текста
 * @param div
 */
function setVisible(div){ //console.log('setVisible called');
    var $=jQuery,
        container,
        sections,
        index,
        nextSection,
        visibleClass ='visible';
    if(checkResolutionMobile()){
        container=$(div).parent();
        nextSection=$(div).next();
    }else{
        container=$(div).parent().next('.menu-container');
        index=$(div).index();
    }
    sections=$('section',container);
    //console.group('element index '+index); console.dir(sections);
    $(sections).removeClass(visibleClass); // visible
    if(index)
        $(sections).eq(index).addClass(visibleClass);
    else{
        //console.dir(nextSection);
        $(nextSection).addClass(visibleClass);
    } //console.dir($(sections).eq(index)); console.groupEnd();
}
/**
 * ПЕРЕМЕСТИТЬ ЭЛЕМЕНТЫ ПРИ ИЗМЕНЕНИИ МАКЕТА
 */
/**
 * Переместить блоки текста для подменю (первое выпадающее меню)
 * @pseudolinks ─ псевдоссылки в первом выпадающем меню
 * @obj ─ texts или menu_container_class
 */
function moveSubmenusTexts(pseudolinks,obj,mobile){
//console.log('start menu rearranging...');
    var $=jQuery;
    $('>div',pseudolinks).each(function(index,element){
        //console.dir(element);
        if(mobile) $(element).after(obj[index]);
        else $(obj).append($(element).next());
    });
}
/**
 * Переместить кнопку "Распечатать адрес"
 */
function movePrintButton(aPrint, mobile){
    var div=aPrint.parent('div').eq(0);
    if(mobile) div.append(aPrint);
    else div.find('p').eq(0).after(aPrint);
}
