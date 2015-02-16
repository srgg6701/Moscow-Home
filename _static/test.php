<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--<link   media="screen, projection" rel="stylesheet" type="text/css" href="/.css">-->
        <!--<script src="/.js"></script>-->
<!-- move styles to a separated file -->
<!-- css->SASS converter: http://css2sass.heroku.com/ -->
<!-- 
PHPStorm settings:
==compass support
====compass executable file:
C:\Ruby200-x64\lib\ruby\gems\2.0.0\gems\compass-0.12.2\bin\compass
====config path:
C:/PHPDevServer/data/localweb/projects/[project_name]/config.rb
==file watchers
====compass scss:
Programm: C:\Ruby200-x64\bin\compass.bat
====SCSS:
Programm: C:\Ruby200-x64\bin\scss.bat -->
<style>
html, body{
	height:100%;
	margin:0;
	padding:0;
}
body *{
    box-sizing: border-box;
    font-family: Arial, Helvetica, Sans-serif;
    overflow: hidden;
}
header{
    height: 20%;
    background: #FFA500;
    min-height: 180px;
}
#nav, main, #footer{
	margin:auto !important;
}
#page {
    background: #0FF;
	box-sizing:border-box;
    height: 600px;
    max-height: 100%;
    position: relative;
}
#slider{
    background: #FF0;
    height: 100px;
    position: absolute;
    bottom: 60px;
    margin-top: -100%;
}
#slider-controls{
    background: lightsalmon;
    bottom: 0;
    height: 80px;
    position: absolute;
    width: 100%;
}
.offsetVertical10,
section{
	padding-top:10px;
	padding-bottom:10px;
}
main{
    height: 60%;
    position: relative;
}
nav{
	padding:10px;
}
footer{
	background-color:lightpink;
    position: absolute;
    bottom: 0;
    height: 110px;
    width: 100%;
}
#footer{
    background: blueviolet;
	height:80px;
	line-height:60px;
	padding:0 10px;
}
nav{
	background-color: #eaebec;
}
</style>
    </head>
    <body>
    	<div id="page">
        	<header>
            	<nav>
                	<div id="nav">Navigation</div>
                </nav>
            </header>
            <main>
                <div id="slider">
                    slider comes here
                </div>
                <div id="slider-controls">
                    <h1>controls</h1>controls
                </div>
            </main>
            <footer>
            	<div id="footer">Footer</div>
            </footer>
        </div>
    </body>
</html>