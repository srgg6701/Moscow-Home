<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="../media/jui/js/jquery.min.js"></script>
        <link rel="stylesheet" href="test.css"/>
    <script>
        function getStyleRuleValue(style, selector, sheet) {
            var sheets = typeof sheet !== 'undefined' ? [sheet] : document.styleSheets;
            for (var i = 0, l = sheets.length; i < l; i++) {
                var sheet = sheets[i];
                if( !sheet.cssRules ) { continue; }
                for (var j = 0, k = sheet.cssRules.length; j < k; j++) {
                    var rule = sheet.cssRules[j];
                    if (rule.selectorText && rule.selectorText.split(',').indexOf(selector) !== -1) {
                        //console.log('selectorText styles: ');
                        //console.dir(rule.style);
                        document.getElementById('styles').innerHTML="width: "+rule.style['cssText'];
                        return rule.style[style];
                    }
                }
            }
            return null;
        }
        jQuery(function($){
            var intv=setTimeout(function(){
                var div = $('#info');
                if(div.size()) {
                    getPxls=function() {
                        var vp, p, htm, getP=function(v,func){
                            p=$(window)[func]()/100*v+'px';
                            htm=$(div).html() + p + '<br>';
                            //console.log('htm: '+htm);
                            $(div).html(htm);
                        };
                        $('.relative-size').each(function (index, element) {
                            //console.dir(element);
                            if(vp=$(element).attr('data-w')){ //console.log('w: '+element);
                                getP(vp,'width');
                            }
                            if(vp=$(element).attr('data-h')){ //console.log('h: '+element);
                                getP(vp,'height');
                            }
                        });
                    };
                        /*var width = getStyleRuleValue('width', '#page');
                         getPxls=function(){
                             console.log('run getPxls first time');
                             //alert(width);
                             var pxls,d=div,w=width;
                             getPxls=function(){
                             console.log('run getPxls again');
                             w='80vw';
                             pxls=$(window).width()/100*parseInt(w)+'px';
                             $(d).html(pxls);
                             };
                             getPxls();
                         };*/
                        getPxls();
                        clearInterval(intv);
                }
                else console.log('no div');
            },100);
            $(window).on('resize',function(){
                console.log('resized...');
                if(typeof (window.getPxls) == 'function') getPxls();
                else console.log('not getPxls');
            });
        }(jQuery));
    </script>
    </head>
    <body>
        <div id="info" class="info"></div>
        <div id="styles" class="info"></div>
    	<div id="page" class="relative-size" data-w="80" data-h="70">
        	<header>
            	<nav>
                	<div id="nav">Navigation</div>
                </nav>
            </header>
            <main>
                <h2>Main comes here...</h2>
                <!--<div id="slider">
                    slider comes here
                </div>
                <div id="slider-controls">
                    <h1>controls</h1>controls
                </div>-->
            </main>
            <footer>
            	<div id="footer">Footer</div>
            </footer>
        </div>
    </body>
</html>