<h4>Задать вопрос</h4>
<form method="post">
    <p>Как вас зовут?
        <input type="text" name="jform[name]"></p>
    <p>Контактный телефон
        <input type="text" name="jform[telephone]"></p>
    <p>Email
        <input type="email" name="jform[email]"></p>
    <p>Текст сообщения
        <textarea></textarea></p>
    <input class="attach-file" type="file" value="Прикрепить файл">
    <input type="hidden" action="sending_email"/>
    <div>
        <input type="submit" value="отправить">
    </div>
</form>