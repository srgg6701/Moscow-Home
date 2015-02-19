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
        <div>
            <aside id="phone-number">+7 (985) 762-99-66</aside>
            <aside id="consulting"><a id="btn-consult" href="#" data-section="ask" class="btn">Консультация</a></aside>
        </div>
    </nav>
    <section class="menu wide">
        <section>
            <div>
                <aside class="float-left">
                    <div class="bgActiveCarrot">Почему мы?</div>
                    <div>Что мы умеем?</div>
                    <div>Какие проекты мы реализовали?</div>
                    <div>Что о нас говорят?</div>
                    <div>Задать вопрос</div>
                </aside>
                <div class="menu-container">
                    <section class="visible">
                        <h3>Компания Moscow Home</h3>
                        <p>Далеко-далеко за словесными горами в стране гласных и согласных живут рыбные тексты. Вдали от всех живут они в буквенных домах на берегу Семантика большого языкового океана.</p>
                        <p>Маленький ручеек Даль журчит по всей стране и обеспечивает ее всеми необходимыми правилами. Эта парадигматическая страна, в которой жаренные члены предложения залетают прямо в рот. Даже всемогущая пунктуация не имеет власти над рыбными текстами.</p>
                    </section>
                    <section>
                        <h3>Что мы умеем</h3>
                        <p>Лежа на панцирнотвердой спине, он видел, стоило ему приподнять голову, свой коричневый, выпуклый, разделенный дугообразными чешуйками живот, на верхушке которого еле держалось готовое вот-вот окончательно сползти одеяло.</p>
                        <p>Его многочисленные, убого тонкие по сравнению с остальным телом ножки беспомощно копошились у него в...</p>
                    </section>
                    <section>
                        <h3>Какие проекты мы реализовали</h3>
                        <p>Да проще сказать, чего не реализовали, ё-моё!</p>
                        <p>Всяко-разно реализовали, реализовали, да не выреализовывали...</p>
                    </section>
                    <section>
                        <h3>Что о нас говорят</h3>
                        <p>Любя, съешь щипцы, — вздохнёт мэр, — кайф жгуч. Шеф взъярён тчк щипцы с эхом гудбай Жюль. Эй, жлоб! Где туз?</p>
                        <p>Прячь юных съёмщиц в шкаф. Экс-граф? Плюш изъят. Бьём чуждый цен хвощ! Эх, чужак! Общий съём цен шляп (юфть) — вдрызг! Любя, съешь щипцы, — вздохнёт мэр, — кайф жгуч. Шеф взъярён тчк щипцы с эхом гудбай Жюль.</p>
                    </section>
                    <section>
                        <h3>Задать вопрос</h3>
                        <p>Мы ответим на каждый ваш вопрос настолько подробно, насколько это возможно вообще!</p>
                    </section>
                </div>
            </div>
        </section>
        <section>
<?php if ($this->countModules('menu-services')) : ?>
    <jdoc:include type="modules" name="menu-services" style="none" />
<?php endif; ?>            <!--<div>
                <h4>Услуги</h4>
                <ul class="you-need">
                    <li title="Проектирование и дизайн">
                        <div>
                            <div><a href="design.html">Проектирование и дизайн</a></div>
                        </div>
                    </li>
                    <li title="Общестроительные и отделочные работы">
                        <div>
                            <div><a href="decoration.html">Общестроительные и отделочные работы</a></div>
                        </div>
                    </li>
                    <li title="Кровельные и фасадные работы">
                        <div>
                            <div><a href="facade.html">Кровельные и фасадные работы</a></div>
                        </div>
                    </li>
                    <li title="Инженерные системы">
                        <div>
                            <div><a href="engineering.html">Инженерные системы</a></div>
                        </div>
                    </li>
                </ul>
            </div>-->
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