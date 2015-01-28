$(function () {
    //console.log('location.href = '+location.href);
    // todo: remove on production
    // ----------------------------------------------------
    // Загрузить тестовый компонент
    if (( location.href.indexOf('localhost') != -1
        || location.href.indexOf('127.0.0.1') != -1)) {
        document.title = window.outerWidth;
        window.onresize = function () {
            document.title = window.outerWidth;
        };
        $('[id^="diigo"]').remove();
        if(location.href.indexOf('?') != -1){
            var tail = location.href.lastIndexOf('/') + 1,
                urlBase = location.href.substring(0, tail),
                params = location.href.substr(tail);
            //console.log('params: ' + params);
            $.get(urlBase + '_dev/debug/dev.php' + params,
                function (data) {
                    //console.log('data: '+data);
                    $('body').prepend(data);
                    //loadTemplate();
                });
        } else {
            console.log('No url params...');
            //loadTemplate();
        }
    }
});
// info: удалить (если используются серверные сценарии) или модифицировать (если используется JS-framework).
// Разобраться с загружаемым шаблоном (если потребуется)
function loadTemplate() {
    var segment_pos,
        section; // шаблон, загружаемый по умолчанию
    if ((segment_pos = location.href.indexOf('=')) != -1) { // если найдено, возвращает позицию, с которой будем начинать извлекать section (после сдвига на 1)
        segment_pos += 1; // скорректировать позицию
        section = (location.href.indexOf('&') != -1) ?
            location.href.substring(segment_pos, location.href.indexOf('&')) : location.href.substring(segment_pos);
    }
    //console.log('url: templates/'+section+'.html');
    // Загрузить шаблон в <main>
    $('main').load('templates/' + section + '.html');
}