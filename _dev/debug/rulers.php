<?php   $rh = 'rulers-horizontal'; $rv = 'rulers-vertical';
?>
<style>
    body{
        position: relative;
    }
    #<?=$rh?>, #<?=$rv?>{
        background-color: red;
        cursor: move;
        opacity: 0.5;
        position: absolute;
        z-index: 10;
    }
    #<?=$rh?>{
        height: 35px;
        top:35px;
        width: 100%;
    }
    #<?=$rv?>{
        bottom:0;
        left: 35px;
        top:0;
        width: 35px;
    }
</style>
<script>
    jQuery(function($){
        var rh = '<?=$rh?>',
            rv = '<?=$rv?>',
            diff= 0,
            attrDr='data-dragged',
            horizontal=$('#'+rh),
            vertical=$('#'+rv);

        var moveRulers = function (event){
            var diff, obj = event.currentTarget;
            //console.log(event.currentTarget);
            $(obj).attr(attrDr,1);
            if(obj.id==rh){
                diff=event.clientY-parseInt($(obj).css('top'));
                //console.log('Down, diff H:'+diff);
            }
            if(obj.id==rv){
                diff=event.clientX-parseInt($(obj).css('left'));
                //console.log('Down, diff: V'+diff);
            }
        };
        $('body *').on('selectstart', function(){
            //console.log(event.currentTarget);
            if($(horizontal).attr(attrDr)||$(vertical).attr(attrDr))
                return false;
        });
        $('body').on('mousemove mouseup', function(event){
            //console.log('event.type = ' + event.type);
            switch (event.type){
                case 'mousemove':
                    if($(horizontal).attr(attrDr)){
                        $(horizontal).css({
                            top:(event.clientY-diff)+window.scrollY+'px'
                        }); //console.log('clientY:'+event.clientY+'\n');
                    }
                    if($(vertical).attr(attrDr)){
                        $(vertical).css({
                            left:(event.clientX-diff)+'px'
                        }); //console.log('clientX:'+event.clientX);
                    }
                    break;
                case 'mouseup':
                    $(horizontal).removeAttr(attrDr);
                    $(vertical).removeAttr(attrDr);
                    break;
            }
        });
        $(horizontal).on('mousedown',function(event){
            moveRulers(event);
        });
        $(vertical).on('mousedown',function(event){
            moveRulers(event);
        });
    })(jQuery);
</script>
<div id="<?=$rh?>"></div>
<div id="<?=$rv?>"></div>