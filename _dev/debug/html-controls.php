<div id="controls">
    <?php
    //
    if (isset($_GET['sbstr']) && $_GET['sbstr'] == 'false')
        $show_substrate = false;
    elseif (!$show_substrate && isset($_GET['sbstr']))
        $show_substrate = true;

    if ($show_substrate):?>
        <label id="lbl-sbstr" title="Подложка">
            <input type="checkbox" id="sbstr"<?php
            $opacity = (isset($_GET['opa'])) ? $_GET['opa'] : 0;
            if ($opacity > 0):?> checked="checked" <?php endif; ?> />
            <img src="_dev/debug/photoshop-substrate.png"/>
        </label>
        <div id="substrate-ranges">
            <label title="Прозрачность подложки">
                <input type="range" id="opacity-range" min="0" max="100" value="<?php echo $opacity * 100; ?>"/>
            </label>
            &nbsp;
            <label title="Прозрачность контента">
                <input type="range" id="opacity-range-content" min="0" max="100" value="100"/>
            </label>
        </div>
        <span id="<?php echo DEBUG_LINKS_ID; ?>">Ссылки</span>
    <?php
    endif;?>
    <div class="<?php echo DEBUG_MENU; ?>">
        <hr/>
        <?php
        // построить меню ссылок:
        foreach ($substrates as $alias => $image):
            ?>
            <a href="?section=<?php echo $alias ?>"><?php echo $alias; ?></a>
        <?php
        endforeach;?>
    </div>
</div>