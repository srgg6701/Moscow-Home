$(function(){
    // ОБРАБОТАТЬ ВЫПАДАЮЩЕЕ МЕНЮ
    //---------------------------------
    var dd_menus=$('nav a[href="#"]'),              // псевдоссылки
        submenu_items=$('header aside >div'),       // внутренние "пункты меню"
        menus_container=getMenusContainer();        // контейнер с блоками меню
    $(menus_container).on('mouseenter mouseleave',/**/ function(event){
        setVisibilityState(event);
    });

    //-----------------------------------------
    // todo: удалить после тестирования
    $(dd_menus).on('click', function(){
        $(getInnerMenus()).hide();
    });

    //-----------------------------------------
    // Скрыть все выпадающие меню
    $('nav a:not([href="#"])').on('mouseenter',hideAll);
    // Управлять выпадающими меню
    $(dd_menus).on('mouseenter mouseleave'/**/, function(event){
        var menu_to_show_index;
        // Отобразить вып. меню и его родительский блок
        if(event.type=='mouseenter'){
            menu_to_show_index=$(dd_menus).index(this);
        }
        // установить состояние видимости
        setVisibilityState(event,menu_to_show_index);
    });
    // Обработать блоки выпадающего меню
    $(submenu_items).on('click mouseenter mouseleave', function(event){
        var container=$(this).parent().next('.container'),
            sections=$('section',container),
            index=$(this).index(),
            bgClass='bgActiveCarrot',
            visibleClass ='visible',
            setVisible=function(){
                $(sections).removeClass(visibleClass)
                    .eq(index).addClass(visibleClass);
            };
        setVisible();
        if(event.type=='click'){
            $(submenu_items).removeClass(bgClass);
            $(this).addClass(bgClass);
        }
        if(event.type=='mouseleave'){
            index=$(this).parent().find('div.'+bgClass).index();
            setVisible();
        }
    });
});
/**
 * Управлять видимостью контейнера с меню
 */
function setVisibilityState(event,menu_to_show_index){
    var active_link,            // Состояние видимости "ссылок"
        visibility_container,   // Состояние видимсти "контейнера меню"
        menu_index;             // Индекс таргет-меню
    setVisibilityState=function (event,menu_to_show_index) {
        if(!isNaN(parseInt(menu_to_show_index)))
            menu_index=menu_to_show_index;
        var target_obj=event.currentTarget.tagName.toLowerCase(),
            action=event.type;
        if(action=='mouseenter'){
            (target_obj=='a')?
                active_link=true
                : visibility_container=true;
        }
        if(action=='mouseleave'){ // уходим с объекта
            (target_obj=='a')?
                // Если уходим со ссылки (не обязательно на блок с меню!), отменяем её "видимость".
                active_link=false
                // Если уходим с блока с меню, также отменяем его видимость
                : visibility_container=false;
        }
        var visibility_stat=(active_link || visibility_container);

        /*console.group('%cvisibility_stat: '+visibility_stat,'font-weight:bold');
            console.log('%cactive_link: '+active_link,'color: darkgoldenrod');
            console.log('%cvisibility_container: '+visibility_container,'color: orange');
            console.log('%cmenu_index: '+menu_index,'color: red');
        console.groupEnd();*/

        $(getInnerMenus()).hide();
        if(visibility_stat){
            $(getMenusContainer()).show(); // отобразить контейнер с меню
            $(getInnerMenus()).eq(menu_index).show();
        }else{
            hideAll();
        }
    };
    setVisibilityState(event,menu_to_show_index);
}
/**
 * Скрыть все меню
 */
function hideAll(){
    $(getInnerMenus()).hide();
    $(getMenusContainer()).hide(); // скрыть контейнер с меню
}
/**
 * Получить контейнер с меню
 * @returns {*|jQuery|HTMLElement}
 */
function getMenusContainer(){
    return $('header >section');
}
/**
 * Получить внутренние блоки контейнера (все вып. меню)
 * @returns {*|jQuery|HTMLElement}
 */
function getInnerMenus(){
    return $('>section',getMenusContainer()); // блоки с меню
}