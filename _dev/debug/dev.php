<!--
// todo: Нормализовать скрипт; в дальнейшем - сделать вариант на чистом JS
1. Добавить директиву подключения этого файла на тестируемую стр. перед тестируемым блоком (обычно - 1-й уровень внутри BODY)
include_once '[path]/dev.php'; -->
<!--
2. Подключить jQuery, jQueryUI
-->
<?php
ob_start();
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
// Стили
require_once 'css.php';
// Вывод ошибок
require_once 'html-errors.php';
// Элементы управления
require_once 'html-controls.php';
//
if ($show_substrate):
    // Обёртка подложки
    require_once 'html-substrate-wrapper.php';
endif;
// Клиентские обработчики
require_once 'js.php';
// Показать линейки
if ($test_rulers) {
    // Вывести линейки
    if (isset($_GET['rulers']))
        require_once 'html-rulers.php';
    // Включение/отключение отображения линейки (через сессию):
    if (isset($_GET[$test_rulers]))
        $_SESSION[$test_rulers] = ($_GET[$test_rulers] == '-1') ? NULL : 1;
}
$content = ob_get_contents();
ob_end_clean();
echo $content;