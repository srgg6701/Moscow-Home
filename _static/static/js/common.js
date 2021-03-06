$(function(){
    // ОБРАБОТАТЬ ВЫПАДАЮЩЕЕ МЕНЮ
    //---------------------------------
    var dd_menus=$('nav a[href="#"]'),              // псевдоссылки
        submenu_items=$('header aside >div'),       // внутренние "пункты меню"
        menus_container=getMenusContainer();        // контейнер с блоками меню

    // управление меню при событии его контейнера
    $(menus_container).on('mouseenter mouseleave',/**/ function(event){
        setVisibilityState(event);
    });

    //-----------------------------------------
    // todo: удалить после тестирования
    $(dd_menus).on('click', function(){
        $(getInnerMenus()).hide();
        $(getMenusContainer()).hide();
    });

    //-----------------------------------------
    // Скрыть все выпадающие меню
    $('nav a:not([href="#"])').on('mouseenter',hideAll);
    // Управлять выпадающими меню
    // todo: добавить mouseleave
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
        var container=$(this).parent().next('.menu-container'),
            sections=$('section',container),
            index=$(this).index(),
            bgClass='bgActiveCarrot',
            visibleClass ='visible',
            setVisible=function(){
                //console.group('element index '+index);
                    //console.dir(sections);
                $(sections).removeClass(visibleClass)
                    .eq(index).addClass(visibleClass);
                    //console.dir($(sections).eq(index));
                //console.groupEnd();
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
    // перегрузить функцию:
    setVisibilityState=function (event,menu_to_show_index) {
        if(!isNaN(parseInt(menu_to_show_index)))
            menu_index=menu_to_show_index;
        var target_obj=event.currentTarget.tagName.toLowerCase(),
            action=event.type,
            active='active';
        //console.log('%caction: '+action,'color:red');console.log('%ctarget: '+target_obj,'color:green');
        if(action=='mouseenter'){
            if(target_obj=='a') {
                active_link=active;
                visibility_container=true;
            }else{
                active_link=true;
                visibility_container=active;
            }
            //console.log('%cvisibility_container: '+visibility_container,'color:violet');
            //console.log('%cactive_link: '+active_link,'color:blue');
        }else
          if(action=='mouseleave' && (visibility_container!=active||active_link!=active)){ // уходим с объекта
              visibility_container=false;
              active_link=false;
            //console.log('%cvisibility_container: '+visibility_container,'color:violet');
            //console.log('%cactive_link: '+active_link,'color:blue');
        }
        var visibility_stat=(active_link || visibility_container);
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