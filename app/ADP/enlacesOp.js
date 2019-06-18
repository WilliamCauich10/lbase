// function principaldatosEnlace() {
//     $.ajax({
//         url: "app/ADP/controlador/dashboard.php",
//         type: "POST",
//         data: { tipo : 'Dashboard2'},
//         success: function(data){
//             $('#tblSindicatos').html(data.options);
//             $("#tabla_municipios").val($("<div>").append($("#tblSindicatos").eq(0).clone()).html());
//         }
//     });
//     //
//     var rawdata;
//     $.ajax({
//         url: "app/ADP/controlador/dashboard.php",
//         type: "POST",
//         data: { tipo : 'prueba'},
//         success: function(data){
//             rawdata = JSON.parse(data);

//                 var chart = new Highcharts.Chart({
//                     chart: {
//                         renderTo: 'graphLinea'
//                     },
//                     title:{
//                         text: 'Avance de Registro'
//                     },
//                     tooltip: {
//                         shared: true
//                         /*formatter: function() {
//                             return 'Total de Eventos: ' + this.y;
//                         }*/
//                     },
//                     plotOptions: {
//                         series: {
//                             label: {
//                               connectorAllowed: false
//                             }
//                         }
//                     },
//                     xAxis: [{
//                         categories:(function(){
//                             var data = [];

//                             for(var i = 0; i < rawdata.length; i++)
//                             {
//                                 data.push([rawdata[i]["fecha"]]);
//                             }
//                             return data;
//                         })()
//                     }],
//                     yAxis: { // Primary
//                         title: {
//                             text: 'Total de registros'
//                         },
//                         plotLines: [{
//                             value: 0,
//                             width: 1,
//                             color: '#808080'
//                         }]
//                     },
//                     series: [{
//                         name: 'Total Plantilla',
//                         type: 'spline',
//                         data: (function(){
//                             var data = [];

//                             for(var i = 0; i < rawdata.length; i++)
//                             {
//                                 data.push([parseInt(rawdata[i]["totalPlantilla"])]);
//                             }
//                             return data;
//                         })()
//                     },{
//                         name: 'Total Militantes',
//                         type: 'spline',
//                         data:
//                             (function(){
//                                 var data = [];

//                                 for(var i = 0; i < rawdata.length; i++)
//                                 {
//                                     data.push([parseInt(rawdata[i]["totalMilitantes"])]);
//                                 }

//                                 return data;
//                             })()
//                     }]
//                 });
//             // $('#tblSindicatos').html(data.options);
//             // $("#tabla_municipios").val($("<div>").append($("#tblSindicatos").eq(0).clone()).html());
//         }
//     });
//     // 
//     $("#Pdatos").load('app/ADP/controlador/dashboard.php',{tipo:'Dashboard1'});
//     $("#Pdatos").show();
// }

function modal_EnlacesOpe(id,Tipo) {
    Tipo_opt =Tipo;
    $("#ModalOp").load("app/ADP/controlador/modalesOp.php",{Id_U: id, tipo: Tipo_opt});
    $("#ModalOp").show();
}
function Busq_User_Create() {
    var Nombre = document.forms["Busqueda_User_Create_ADP"]["input_nombre_Busq"].value;
    var APP = document.forms["Busqueda_User_Create_ADP"]["input_ape_pat_Busq"].value;
    var APM = document.forms["Busqueda_User_Create_ADP"]["input_ape_mat_Busq_PA"].value;
    $('#Busqueda_User_Create_ADP').submit(function() {
        $.ajax({
            type: 'POST',
            url: '',
            data: '',
            contentType: false,
            processData: false,
            success: function(data) {
                // tabla resultados
                document.getElementById('ResultadosBusqCrear').style.display = 'block';
                $("#ResultadosBusqCrear").load('app/ADP/controlador/tabla_busquedaUser.php',{nombre: Nombre, apellido: APP, apellidoMat: APM});
                $("#ResultadosBusqCrear").show();
                // eliminar div de busqueda
                document.getElementById('busquedaForm').style.display = 'none';
            }
        });
        return false;
    });
}
// Seleccionar usuario para enlace operativo
function UserSelectADP(id) {
    document.getElementById('ResultadosBusqCrear').style.display = 'none';
    document.getElementById('formOpt').style.display = 'block';
     // formOpt
     $("#formOpt").load('app/ADP/controlador/formOpt.php',{tipo: 'CreateUserUP',idUser: id});
     $("#formOpt").show();
    // console.log(id+"prueba")
}
// agregar usuario para enlace operativo
function createOpt(){
    document.getElementById('ResultadosBusqCrear').style.display = 'none';
    document.getElementById('formOpt').style.display = 'block';
    // formOpt
    $("#formOpt").load('app/ADP/controlador/formOpt.php',{tipo: 'Crear'});
    $("#formOpt").show();
}
function GuardarFormCreUP(idUser){
    var Nombre = document.forms["formCrearUPOpt"]["input_nombre_Opt"].value;
    var APP = document.forms["formCrearUPOpt"]["input_ape_pat_Opt"].value;
    var APM = document.forms["formCrearUPOpt"]["input_ape_mat_Opt"].value;
    var Direccion = document.forms["formCrearUPOpt"]["input_direccion_opt_nw"].value;
    var Telefono = document.forms["formCrearUPOpt"]["input_tel_Opt"].value;
    var Seccion = document.forms["formCrearUPOpt"]["input_Seccion_PA"].value;
    var Correo = document.forms["formCrearUPOpt"]["input_email_Opt"].value;
    var Contraseña = document.forms["formCrearUPOpt"]["input_contraseña_Opt"].value;
    var NombreEnlace = document.forms["formCrearUPOpt"]["input_nombre_Enlace_Opt"].value;    
    // alert("ASAd");
    $('#formCrearUPOpt').submit(function() {
        $.ajax({
            type: 'POST',
            url: '',
            data: '',
            contentType: false,
            processData: false,
            success: function(data) {                
                // Guardar Datos                 
                $("#resultados").load('app/ADP/controlador/acciones.php',{OPT: 'CrearEnlaceUpUser', NombreEnlace: NombreEnlace,
                idUser: idUser,Nombre: Nombre, APP: APP, APM: APM,Direccion: Direccion, Telefono: Telefono,Correo: Correo, Contraseña: Contraseña, Seccion: Seccion});
                $("#resultados").show();
            }
        });
        return false;
    });
}
function principalEnlacesOP(){
    $("#page_content").load("app/ADP/vista/Enlaces/view_enlaces.php");
    $("#page_content").show();
}
function borrarEnlace(id){
    $("#resultados").load('app/ADP/controlador/acciones.php',{OPT: 'BorrarEnlace',idEnlace: id});
    $("#resultados").show();
    // console.log(id);
}
function GuardarFormCreNW(){
    var Nombre = document.forms["formCrearEnUser"]["input_nombre_Opt"].value;
    var APP = document.forms["formCrearEnUser"]["input_ape_pat_Opt"].value;
    var APM = document.forms["formCrearEnUser"]["input_ape_mat_Opt"].value;
    var Direccion = document.forms["formCrearEnUser"]["input_direccion_opt_nw"].value;
    var Telefono = document.forms["formCrearEnUser"]["input_tel_Opt"].value;
    var Seccion = document.forms["formCrearEnUser"]["input_Seccion_PA"].value;
    var Correo = document.forms["formCrearEnUser"]["input_email_Opt"].value;
    var Contraseña = document.forms["formCrearEnUser"]["input_contraseña_Opt"].value;
    var NombreEnlace = document.forms["formCrearEnUser"]["input_nombre_Enlace_Opt"].value;    
    // alert("ASAd");
    $('#formCrearEnUser').submit(function() {
        $.ajax({
            type: 'POST',
            url: '',
            data: '',
            contentType: false,
            processData: false,
            success: function(data) {                
                // Guardar Datos                 
                $("#resultados").load('app/ADP/controlador/acciones.php',{OPT: 'CrearEnlaceNWUser', NombreEnlace: NombreEnlace,
                Nombre: Nombre, APP: APP, APM: APM,Direccion: Direccion, Telefono: Telefono,Correo: Correo, Contraseña: Contraseña, Seccion: Seccion});
                $("#resultados").show();
            }
        });
        return false;
    });
}
// function SubmiNWOpt() {
//     var Nombre = document.forms["formCrearOpt"]["input_nombre_Busq"].value;
//     var APP = document.forms["formCrearOpt"]["input_ape_pat_Busq"].value;
//     $('#formCrearOpt').submit(function() {
//         $.ajax({
//             type: 'POST',
//             url: '',
//             data: '',
//             contentType: false,
//             processData: false,
//             success: function(data) {
//                 // tabla resultados
//                 // document.getElementById('ResultadosBusqCrear').style.display = 'block';
//                 // $("#ResultadosBusqCrear").load('app/ADP/controlador/tabla_busquedaUser.php',{nombre: Nombre, apellido: APP});
//                 // $("#ResultadosBusqCrear").show();
//                 // // eliminar div de busqueda
//                 // document.getElementById('busquedaForm').style.display = 'none';
//             }
//         });
//         return false;
//     });
// }

