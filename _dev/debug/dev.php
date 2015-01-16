<?php
/**
    todo: Нормализовать скрипт; в дальнейшем - сделать вариант на чистом JS
1. Добавить директиву подключения этого файла на тестируемую стр. перед тестируемым блоком (обычно - 1-й уровень внутри BODY)
include_once '[path]/dev.php';
2. Подключить jQuery, jQueryUI */
// Установки проекта тестирования
require_once 'config.php';
// Изображения для страниц:
$substrates = array(    // класс => имя файла изображения
    // 320
    'home' => '0.home.png',
    'buildings-premises-design' => '1.buildings-premises-design.jpg',
    'roofing-facade-work' => '2.roofing-facade-work.jpg',
    'construction-finishing-work' => '3.construction-finishing-work.jpg',
    'engineering-systems' => '4.engineering-systems.jpg',
);

ob_start();
// Стили
require_once 'css.php';
// Вывод ошибок
require_once 'html-errors.php';
// Элементы управления
require_once 'html-controls.php';
// Обёртка подложки
if ($show_substrate)
    require_once 'html-substrate-wrapper.php';
// Клиентские обработчики
require_once 'js.php';
// разобраться с подключением линеек
if (isset($_GET['rulers'])):
    ($_GET['rulers'] == '-1') ?
        $_SESSION['rulers']=NULL
        : $_SESSION['rulers']= 1;
endif;
// линейки
if (isset($_SESSION['rulers'])&&$_SESSION['rulers'])
    require_once 'rulers.php';

$content = ob_get_contents();
ob_end_clean();
echo $content;
