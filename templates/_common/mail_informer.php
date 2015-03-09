<?php
if(isset($mail_sent)):?>
<div class="fixed" id="mail-informer">
    <h4>Спасибо за сообщение!</h4>
    <p>Мы свяжемся с вами в ближайшее время.</p>
    <a href="javascript:void(0)" onclick="return closeParent(event);" class="close">x</a>
</div>
<script>
    var fading=setTimeout(function(){
       jQuery('#mail-informer').fadeOut(24000);
    },4000);
</script>
<?php endif;