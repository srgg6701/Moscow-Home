<script>
    $(function(){
        var body=$('body'),
            page = $('<?php echo MAIN_BLOCK;?>'),
            checkbox =$('#sbstr'),
            substrate = $('<?php echo SUBSTRATE_ID;?>'),
            range = $('<?php echo OPACITY_RANGE_ID;?>'),
            tested_content = $('<?php echo OPACITY_RANGE_CONTENT_ID;?>'),
            wrapper=$('<?php echo SUBSTRATE_WRAPPER_ID;?>'),
            w = screen.width,// вычислить отступ слева для подложки
            sbOffset=((w-$(wrapper)[0].scrollWidth)/ 2)/w * 100 + '%',
            changeOpacity = function(input){
                return parseInt(input.value)/100
            }; console.log('wrapper.scrollWidth: '+$(wrapper)[0].scrollWidth+', w: '+w+', sbOffset: '+sbOffset);
        $(wrapper).css({
            left:sbOffset,
            right:sbOffset
        });
        // переключатель видимости подложки
        $(checkbox).on('click', function(){
            // если подложка скрыта
            if(!$(substrate).is(':visible')||$(substrate).css('opacity')==0){
                // установить ползунок прозрачности макета
                // установить полупрозрачность макета */
                triggerRanges(tested_content,50);
                // синхронизировать ползунок подложки
                // установить полную непрозрачность подложки */
                triggerRanges(range,100);
            }else{ // подложка отображена
                // сбросить в ноль ползунок подложки
                // скрыть подложку */
                triggerRanges(range,0);
            }
        });
        $(range).on('input', function(){
            var cbox=$(checkbox)[0], opa = changeOpacity(this);
            if(opa>0) {
                if(!cbox.checked) cbox.checked=true;
            }else{
                cbox.checked=false;
                // синхронизировать ползунок контента (установить в максимум)
                // установить непрозрачность макета */
                triggerRanges(tested_content,100);
            }
            $(substrate).css({
                display:'block',
                opacity:opa
            });
        });
        $(tested_content).on('input', function(){
            $(page).css('opacity', changeOpacity(this));
        });
        $('<?php echo DEBUG_LINKS_ID?>').on('click', function(){
            $('.<?php echo DEBUG_MENU;?>').toggle();
        });
        <?php
        //------------------------------------------------
        // ЛИНЕЙКА
        if($test_rulers) {
            if (isset($_GET['rulers'])):?>
        <?php
                $rh = 'rulers-horizontal';
                $rv = 'rulers-vertical';
         ?>
        var rh = '<?=$rh?>',
            rv = '<?=$rv?>',
            diff = 0,
            attrDr = 'data-dragged',
            horizontal = $('#' + rh),
            vertical = $('#' + rv),
            moveRulers = function (event) {
                var obj = event.currentTarget;
                //console.log(event.currentTarget);
                $(obj).attr(attrDr, 1);
                if (obj.id == rh) {
                    diff = event.clientY - parseInt($(obj).css('top'));
                    //console.log('Down, diff H:'+diff);
                }
                if (obj.id == rv) {
                    diff = event.clientX - parseInt($(obj).css('left'));
                    //console.log('Down, diff: V'+diff);
                }
            };

        $('*',body).on('selectstart', function () {
            //console.log(event.currentTarget);
            if ($(horizontal).attr(attrDr) || $(vertical).attr(attrDr))
                return false;
        });
        $(body).on('mousemove mouseup', function (event) {
            //console.log('event.type = ' + event.type);
            switch (event.type) {
                case 'mousemove':
                    if ($(horizontal).attr(attrDr)) {
                        $(horizontal).css({
                            top: (event.clientY - diff) + window.scrollY + 'px'
                        }); //console.log('clientY:'+event.clientY+'\n');
                    }
                    if ($(vertical).attr(attrDr)) {
                        $(vertical).css({
                            left: (event.clientX - diff) + 'px'
                        }); //console.log('clientX:'+event.clientX);
                    }
                    break;
                case 'mouseup':
                    $(horizontal).removeAttr(attrDr);
                    $(vertical).removeAttr(attrDr);
                    break;
            }
        });
        $(horizontal).on('mousedown', function (event) {
            moveRulers(event);
        });
        $(vertical).on('mousedown', function (event) {
            moveRulers(event);
        });
<?php       endif;
        }?>
    });
    // установить значение ползунка и прозрачность блока (макет или подложка)
    function triggerRanges(rang,value){
        $(rang).val(value) // синхронизировать ползунок
            .trigger('input'); // установить прозрачность блока
    }
</script>