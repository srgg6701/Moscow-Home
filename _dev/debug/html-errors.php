<?php
if (isset($wrongPaths)):
foreach ($wrongPaths as $wPath) {
?>
<div class="error_warning">
    Не найден файл подложки <?php echo $wPath; ?>
</div>
<?php
}
endif;
//
if (!defined("MAIN_BLOCK")) {
    ?>
    <div class="error_warning"><b>Ошибка!</b>

        <p>Не указан идентификатор контейнера для тестирования (MAIN_BLOCK)</p>
    </div>
<?
}