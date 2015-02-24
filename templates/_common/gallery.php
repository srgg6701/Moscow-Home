<script>
    $(function(){
<?php
if($main_page):?>
        $('.slider-bottom .slides').on('click', function(){
            location.href=location.pathname+'gallery';
        });
<?php
endif;?>
    });
</script>