<?php   /*
   ВНИМАНИЕ!
        Выбор и последовательность размещения/вложения элементов
        header > section > section и nav a
        должна быть соблюдена для правильной работы обработчика выпадающего меню!*/
?><header>
    <nav>
<?php if ($this->countModules('header-nav')) : ?>
    <jdoc:include type="modules" name="header-nav" style="none" />
<?php endif; ?>
        <div>
            <?php if($pageclass!="print-contacts"):?>
                <a id="logo" href="<?php echo $this->baseurl;?>"></a>
            <?php endif;?></div>
        <?php if ($this->countModules('header-contacts')) : ?>
            <jdoc:include type="modules" name="header-contacts" style="none" />
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
                <?php if ($this->countModules('menu-contacts')) : ?>
                    <jdoc:include type="modules" name="menu-contacts" style="none" />
                <?php endif; ?>
            </div>
        </section>
        <section>
            <?php if ($this->countModules('menu-ask-question')) : ?>
                <jdoc:include type="modules" name="menu-ask-question" style="none" />
            <?php endif; ?>
            <div class="bottom-bg"></div>
        </section>
        <?php if ($this->countModules('footer-mobile-menu')) : ?>
            <jdoc:include type="modules" name="footer-mobile-menu" style="none" />
        <?php endif; ?>
        <div id="menus-subheader-mobile">Заголовок меню</div>
    </section>
</header>
