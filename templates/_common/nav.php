<?php   /*
   ВНИМАНИЕ!
        Выбор и последовательность размещения/вложения элементов
        header > section > section и nav a
        должна быть соблюдена для правильной работы обработчика выпадающего меню!*/
?><header class="absolute">
    <nav>
<?php if ($this->countModules('header-nav')) : ?>
    <jdoc:include type="modules" name="header-nav" style="none" />
<?php endif; ?>
        <div><a id="logo" href="index.html"></a></div>
        <?php if ($this->countModules('menu-contacts')) : ?>
            <jdoc:include type="modules" name="menu-contacts" style="none" />
        <?php endif; ?>
    </nav>
    <section class="menu wide">
        <section>
            <?php if ($this->countModules('menu-about')) : ?>
                <jdoc:include type="modules" name="menu-about" style="none" />
            <?php endif; ?>
        </section>
        <section>
<?php if ($this->countModules('menu-services')) : ?>
    <jdoc:include type="modules" name="menu-services" style="none" />
<?php endif; ?>
        </section>
        <section>
            <div>
                <h4>Контакты</h4>
                <div>
                    <p>Россия, МО, Рублёво-Успенское шоссе, д.6, &laquo;Торгово-деловой центр 1 км&raquo;</p>
                    <button class="print"><span>Распечатать адрес</span></button>
                    <p><strong>Телефон:</strong>+7 495 890-0909</p>
                    <p><strong>Email:</strong><span class="email">&nbsp;</span></p>
                </div>
                <div id="map" style="height:230px;width:auto;">
                    <div id="waiting-map">...загрузка карты...</div>
                </div>
            </div>
        </section>
        <section>
            <div class="centered">
                <h4>Задать вопрос</h4>
                <form method="post">
                    <p>Как вас зовут?
                        <input type="text" name="name"></p>
                    <p>Контактный телефон
                        <input type="text" name="telephone"></p>
                    <p>Email
                        <input type="email" name="email"></p>
                    <p>Текст сообщения
                        <textarea></textarea></p>
                    <button class="attach-file">Прикрепить файл</button>
                    <div>
                        <input type="submit" value="отправить">
                    </div>
                </form>
            </div>
            <div class="bottom-bg"></div>
        </section>
    </section>
</header>