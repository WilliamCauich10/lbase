<?php
 session_start();

    if(!isset($_SESSION['id_usuario']))
    {
        header("Location: index.php");
        exit();
    }

    include_once('config/database.php');
    $pdo = Database::getInstance()->getPdoObject();
    header("Content-Type: text/html;charset=utf-8");
     // file_get_contents('assets/js/altair_admin_common.min.js');
    // requiere_once()
    // header('Access-Control-Allow-Origin: *');
 ?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>

    <link rel="icon" type="image/png" href="assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="assets/img/favicon-32x32.png" sizes="32x32">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>

    <title>Inicio</title>

    <!-- additional styles for plugins -->
        <!-- weather icons -->
        <link rel="stylesheet" href="bower_components/weather-icons/css/weather-icons.min.css" media="all">
        <!-- metrics graphics (charts) -->
        <link rel="stylesheet" href="bower_components/metrics-graphics/dist/metricsgraphics.css">
        <!-- chartist -->
        <!-- <link rel="stylesheet" href="bower_components/chartist/dist/chartist.min.css"> -->

    <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

    <!-- flag icons -->
    <link rel="stylesheet" href="assets/icons/flags/flags.min.css" media="all">

    <!-- style switcher -->
    <link rel="stylesheet" href="assets/css/style_switcher.min.css" media="all">

    <!-- altair admin -->
    <link rel="stylesheet" href="assets/css/main.min.css" media="all">

    <!-- themes -->
    <link rel="stylesheet" href="assets/css/themes/themes_combined.min.css" media="all">

    <!-- menu -->
    <!-- <link rel="stylesheet" type="text/css" href="assets/css/menu.css"> -->
    
</head>
<body class=" sidebar_main_open sidebar_main_swipe">
    <!-- main header -->
    <header id="header_main" style="height:85px;
background-image: url(assets/img/banner.jpg);
background-size: cover;
background-position: center;">
        <div class="header_main_content" style="padding-top: 20px;">
            <nav class="uk-navbar">

                <!-- main sidebar switch -->
                <a href="#" id="sidebar_main_toggle" class="sSwitch sSwitch_left">
                    <span class="sSwitchIcon"></span>
                </a>

                <!-- secondary sidebar switch -->
                <a href="#" id="sidebar_secondary_toggle" class="sSwitch sSwitch_right sidebar_secondary_check">
                    <span class="sSwitchIcon"></span>
                </a>
                <!-- perfil -->
                <div class="uk-navbar-flip">
                   <a id="btn_logout" class="uk-icon-button uk-icon-sign-out" title="Salir"></a>
                </div>
            </nav>
        </div>

    </header><!-- main header end -->

    <!-- main sidebar style="    background-position: 4px -36px;" -->
    <aside id="sidebar_main" style="background-color:#3C4754;">

        <div class="sidebar_main_header" >
        <img src="http://inmonitor.red70s.net/lbase/lbase.png" style="height:80px;">
            <div class="sidebar_logo" style="height:88px;">
                <!-- <a href="" class="sSidebar_hide sidebar_logo_large">
                    <img class="md-user-image" src="assets/img/avatars/user.png" alt=""/>
                </a> -->
                <?php  // echo utf8_decode($_SESSION['nombre']).' '.utf8_decode($_SESSION['apellido_paterno']); ?>
            </div>
                <!-- <a id="btn_logout" onclick="salir()">Logout</a> -->
        </div>

        <div class="menu_section" id="menu_section">
           <div class="sidenav" style= "background-color:#3C4754;">
               <?php

                        include ("menu.php");
                  ?>
            </div>
        </div>
    </aside>
    <!-- main sidebar end -->
<!-- Content -->
<div id="page_content" style="padding-top: 60px;">
    <div id="page_content_inner" >      
         <!-- <div class="md-card-content" id="table_Temas" > -->
<!-- </div> -->
    </div>
</div>
<!-- fin content -->
 
<!-- Para todo -->
     <!-- Afuerza -->
    <script src="assets/js/common.min.js"></script>
    <script src="assets/js/uikit_custom.min.js"></script>
    <script src="assets/js/altair_admin_common.js"></script>
    
    <!-- <script src="assets/js/pages/page_chat.min.js"></script> -->
    

    <script>
        $(function() {
            var $switcher = $('#style_switcher'),
                $switcher_toggle = $('#style_switcher_toggle'),
                $theme_switcher = $('#theme_switcher'),
                $mini_sidebar_toggle = $('#style_sidebar_mini'),
                $slim_sidebar_toggle = $('#style_sidebar_slim'),
                $boxed_layout_toggle = $('#style_layout_boxed'),
                $accordion_mode_toggle = $('#accordion_mode_main_menu'),
                $html = $('html'),
                $body = $('body');


            $switcher_toggle.click(function(e) {
                e.preventDefault();
                $switcher.toggleClass('switcher_active');
            });

            $theme_switcher.children('li').click(function(e) {
                e.preventDefault();
                var $this = $(this),
                    this_theme = $this.attr('data-app-theme');

                $theme_switcher.children('li').removeClass('active_theme');
                $(this).addClass('active_theme');
                $html
                    .removeClass('app_theme_a app_theme_b app_theme_c app_theme_d app_theme_e app_theme_f app_theme_g app_theme_h app_theme_i app_theme_dark')
                    .addClass(this_theme);

                if(this_theme == '') {
                    localStorage.removeItem('altair_theme');
                    $('#kendoCSS').attr('href','bower_components/kendo-ui/styles/kendo.material.min.css');
                } else {
                    localStorage.setItem("altair_theme", this_theme);
                    if(this_theme == 'app_theme_dark') {
                        $('#kendoCSS').attr('href','bower_components/kendo-ui/styles/kendo.materialblack.min.css')
                    } else {
                        $('#kendoCSS').attr('href','bower_components/kendo-ui/styles/kendo.material.min.css');
                    }
                }

            });
            // get theme from local storage
            if(localStorage.getItem("altair_theme") !== null) {
                $theme_switcher.children('li[data-app-theme='+localStorage.getItem("altair_theme")+']').click();
            }

        });
    </script>
<script type="application/javascript">
    var sessionTipoU = "<?php echo $_SESSION['tipo_usuario'] ?>";
    principal(sessionTipoU);
    function principal(user) {
        var src="";
        switch (user) {
            case 'ADP':
                    document.write('<script src="app/ADP/enlacesOp.js" type="text/javascript"><\/script>');
                    $("#page_content").load("app/ADP/vista/Enlaces/view_enlaces.php");
                    $("#page_content").show();
            break;
            case 'EO':
                    document.write('<script src="app/EO/enlacesEO.js" type="text/javascript"><\/script>');
                    $("#page_content").load("app/EO/inicio.php");
                    $("#page_content").show();
            break;
            case 'PA':
                    document.write('<script src="app/PA/enlacesEO.js" type="text/javascript"><\/script>');
                    $("#page_content").load("app/PA/inicio.php");
                    $("#page_content").show();
            break;
            default:
                break;
        }
    }
    function Menu(va) {
        var elemento = document.getElementsByClassName("active");
        var elementoActivo = document.getElementById(va); 
        for(var i = 0; i < elemento.length; i++){
            elemento[i].className = "Menu_";
        }
        elementoActivo.setAttribute("class","active");
    }
    function CargarPaginas(ruta) {
        $("#page_content").load(ruta);
        $("#page_content").show();
    }
    // salir();
    function salir(){
        window.location.replace('index.php?logout=logout');
    }
     $('#btn_logout').on('click',function(){
        window.location.replace('index.php?logout=logout');
    });

</script>
<script>
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
</script>

</body>
<!-- <script type="text/javascript" id="script" src="app/EO/enlacesEO.js"></script> -->
<!-- <script src="app/ADP/enlacesOp.js" type="text/javascript"></script>  -->
<!-- <script src="app/EO/enlacesEO.js" type="text/javascript"></script>  -->
<!-- <script src="app/PA/enlacesEO.js" type="text/javascript"></script>  -->
<!--  notifications functions -->
<script src="assets/js/pages/components_notifications.min.js"></script>

<!--  -->

</html>
