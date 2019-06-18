// datos principales
// principaldatosEnlace();   
function principalDatos() {
    $("#Pdatos").load("app/EO/controlador/padron/datosPrincipal.php");
    $("#Pdatos").show();    
}
function principaldatosEnlace() {
    $.ajax({
        url: "app/EO/controlador/dashboard.php",
        type: "POST",
        data: { tipo : 'Dashboard2'},
        success: function(data){
            $('#tblSindicatos').html(data.options);
            $("#tabla_municipios").val($("<div>").append($("#tblSindicatos").eq(0).clone()).html());
        }
    });
    //
    var rawdata;
    $.ajax({
        url: "app/EO/controlador/dashboard.php",
        type: "POST",
        data: { tipo : 'prueba'},
        success: function(data){
            rawdata = JSON.parse(data);

                var chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'graphLinea'
                    },
                    title:{
                        text: 'Avance de Registro'
                    },
                    tooltip: {
                        shared: true
                        /*formatter: function() {
                            return 'Total de Eventos: ' + this.y;
                        }*/
                    },
                    plotOptions: {
                        series: {
                            label: {
                              connectorAllowed: false
                            }
                        }
                    },
                    xAxis: [{
                        categories:(function(){
                            var data = [];

                            for(var i = 0; i < rawdata.length; i++)
                            {
                                data.push([rawdata[i]["fecha"]]);
                            }
                            return data;
                        })()
                    }],
                    yAxis: { // Primary
                        title: {
                            text: 'Total de registros'
                        },
                        plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                    },
                    series: [{
                        name: 'Total Plantilla',
                        type: 'spline',
                        data: (function(){
                            var data = [];

                            for(var i = 0; i < rawdata.length; i++)
                            {
                                data.push([parseInt(rawdata[i]["totalPlantilla"])]);
                            }
                            return data;
                        })()
                    },{
                        name: 'Total Militantes',
                        type: 'spline',
                        data:
                            (function(){
                                var data = [];

                                for(var i = 0; i < rawdata.length; i++)
                                {
                                    data.push([parseInt(rawdata[i]["totalMilitantes"])]);
                                }

                                return data;
                            })()
                    }]
                });
        }
    });
    // 
    $.ajax({
        url: "app/EO/controlador/dashboard.php",
        type: "POST",
        data: { tipo : 'Dashboard1'},
        success: function(data){
            $('#Pdatos').html(data.options);
            // $('#tblSindicatos').html(data.options);
            // $("#tabla_municipios").val($("<div>").append($("#tblSindicatos").eq(0).clone()).html());
        }
    });    
    crearGraficaSindicatos(0);
    obtenerTablaGraficaSindicatos(0);
    crearGraficaMunicipios(0);
    obtenerTablaGraficaMunicipios(0);
    obtenerTablaSecciones(0);
}
function obtenerTablaSecciones(segmento) {
    $.ajax({
        url: "app/EO/controlador/dashboard.php",
        type: "POST",
        data: { tipo : 'DispersionDashboard',segmento: segmento},
        success: function(data){
            $('#tblSecciones').html(data.options);
            var nombreSegmento =$('select[name="select_sindicato"] option:selected').text();
            $("#nombre_sindicato").val(nombreSegmento);
            $("#datos_a_enviar").val($("<div><H3>Segmento: " + $("#nombre_sindicato").val() + "</H3>").append( $("#tblSecciones").eq(0).clone()).html());
        }
    });
}
function crearGraficaSindicatos(distrito) {
    $("#distrito_local").val(distrito);
    $.ajax({
        url: "app/EO/controlador/dashboard.php",
        type: "POST",
        data: { tipo : 'graficaSindicatos',distrito : distrito},
        success: function(data){
            // $('#tblSecciones').html(data.options);
            rawdata = JSON.parse(data);

            var chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'graficaSindicatos',
                    type: 'pie'
                },
                title:{
                    text: 'Total de integrantes por Segmento'
                },
                tooltip: {
                    /*pointFormat: '{series.name}'*/
                    formatter: function() {
                        return 'Integrantes: ' + this.y;
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                    }
                },
                series: [{
                    name: 'Integrantes',
                    type: 'pie',
                    data: (function(){
                        var data = [];

                        for(var i = 0; i < rawdata.length; i++)
                        {
                            data.push({
                                'name': rawdata[i]["Nombre_Seg"],
                                'y': parseInt(rawdata[i]["PADRONES"])
                            })
                        }
                        return data;
                    })()
                }]
            });
        }
    });
}
function obtenerTablaGraficaSindicatos($distrito){
    $.ajax({
        url: "app/EO/controlador/dashboard.php",
        type: "POST",
        data: { tipo : 'obtenerTablaGraficaSindicatos',distrito : $distrito },

        success: function(data)
        {
            $('#tblGraficaSindicatos').html(data.options);
            $("#tabla_SindicatosDistrito").val($("<div><H3>Distrito Local: " + $("#distrito_local").val() + "</H3>").append( $("#tblGraficaSindicatos").eq(0).clone()).html());
        }
    });
}
// 
function crearGraficaMunicipios(municipio){
        $.ajax({
            url: "app/EO/controlador/dashboard.php",
            type: "POST",
            data: { tipo : 'graficaMunicipios', municipio : municipio },

            success: function(data)
            {
                rawdata = JSON.parse(data);

                var chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'graficaMunicipios',
                        type: 'pie'
                    },
                    title:{
                        text: 'Total de integrantes por Sindicato'
                    },
                    tooltip: {
                        /*pointFormat: '{series.name}'*/
                        formatter: function() {
                            return 'Integrantes: ' + this.y;
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                        }
                    },
                    series: [{
                        name: 'Integrantes',
                        type: 'pie',
                        data: (function(){
                            var data = [];

                            for(var i = 0; i < rawdata.length; i++)
                            {
                                data.push({
                                    'name': rawdata[i]["segmento"],
                                    'y': parseInt(rawdata[i]["total"])
                                })
                            }
                            return data;
                        })()
                    }]
                });
            }
        });
    }
    // 
function obtenerTablaGraficaMunicipios(municipio){
    $("#mpio").val(municipio);
    $.ajax({
        url: "app/EO/controlador/dashboard.php",
        type: "POST",
        data: { tipo : 'obtenerTablaGraficaMunicipios', municipio : municipio },

        success: function(data)
        {
            $('#tblGraficaMunicipios').html(data.options);
            $("#tabla_SindicatosMunicipio").val($("<div><H3>Municipio: " + $("#mpio").val() + "</H3>").append($("#tblGraficaMunicipios").eq(0).clone()).html());
        }
    });
}
function exportarDetalle(){
    var distrito = $("#select_distrito").val();
    // console.log(distrito);
    location.href='app/exportar/exportarDistrito.php?distrito=' + distrito+'&tipo=EO';
}
function exportarDetalleMunicipio(){
    var municipio = $("#select_municipio").val();
    location.href='app/exportar/exportarMunicipio.php?municipio=' + municipio+'&tipo=EO';
}
// busqueda usuario padron
function Busq_User_Create_EO(idPadron) {
    var Nombre = document.forms["Busqueda_User_Create_EO"]["input_nombre_Busq"].value;
    var APP = document.forms["Busqueda_User_Create_EO"]["input_ape_pat_Busq"].value;
    var APM = document.forms["Busqueda_User_Create_EO"]["input_ape_mat_Busq"].value;
    $('#Busqueda_User_Create_EO').submit(function() {
        $.ajax({
            type: 'POST',
            url: '',
            data: '',
            contentType: false,
            processData: false,
            success: function(data) {
                // tabla resultados
                document.getElementById('ResultadosBusqCrear_EO').style.display = 'block';
                $("#ResultadosBusqCrear_EO").load('app/EO/controlador/enlaces/tabla_busquedaUser.php',{nombre: Nombre, apellido: APP,idPadron: idPadron,apellidoMat: APM});
                $("#ResultadosBusqCrear_EO").show();
                // eliminar div de busqueda
                document.getElementById('busquedaForm_EO').style.display = 'none';
            }
        });
        return false;
    });
}
// busqueda padron usuarios
function Busq_User_Create_PA(idPadron) {
    var Nombre = document.forms["Busqueda_User_Create_PA"]["input_nombre_Busq_PA"].value;
    var APP = document.forms["Busqueda_User_Create_PA"]["input_ape_pat_Busq_PA"].value;
    var APM = document.forms["Busqueda_User_Create_PA"]["input_ape_mat_Busq_PA"].value;
    $('#Busqueda_User_Create_PA').submit(function() {
        $.ajax({
            type: 'POST',
            url: '',
            data: '',
            contentType: false,
            processData: false,
            success: function(data) {
                // alert(idPadron)
                document.getElementById('ResultadosBusqCrear_PA').style.display = 'block';
                $("#ResultadosBusqCrear_PA").load('app/EO/controlador/padron/tabla_busquedaUser.php',{nombre: Nombre, apellido: APP, apellidoMat:APM,idPadron: idPadron,});
                $("#ResultadosBusqCrear_PA").show();
                // eliminar div de busqueda
                document.getElementById('busquedaForm_PA').style.display = 'none';
            }
        });
        return false;
    });
}
// seleccionar usuario padron contactos
function UserSelect(IdUsuario,IdPadron) {
    jQuery('#ModalCrearDetalle').click();
    var modal = UIkit.modal.blockUI('<div class=\'uk-text-center\'><br/><img class=\'uk-margin-top\' src=\'assets/img/spinners/spinner.gif\' alt=\'\'>');
    $.ajax({
        url: "app/EO/controlador/crear.php",
        type: "POST",
        data: { idUser: IdUsuario, tipo: 'PadronUP'},
        success: function(data){
            $('#form1').html(data.options);
            if($('#form1').html()) {
                // console.log('Yes content');
                modal.hide();
              } else {          
                // console.log('No content');
                setTimeout(function(){
                    modal.hide(); 
                    alert("hubo un problema recarga la pagina");
                }, 10000);
              }
        }
    });
}
// crear usuario contactos padrondetalle
// function createEO(){
//     jQuery('#ModalCrearDetalle').click();
//     var modal = UIkit.modal.blockUI('<div class=\'uk-text-center\'><br/><img class=\'uk-margin-top\' src=\'assets/img/spinners/spinner.gif\' alt=\'\'>');
//     $.ajax({
//         url: "app/EO/controlador/enlaces/CrarDetalle.php",
//         type: "POST",
//         data: {tipo: 'DetalleNW'},
//         success: function(data){
//             $('#form1').html(data.options);
//             if($('#form1').html()) {
//                 // console.log('Yes content');
//                 modal.hide();
//               } else {          
//                 // console.log('No content');
//                 setTimeout(function(){
//                     modal.hide(); 
//                     alert("hubo un problema recarga la pagina");
//                 }, 10000);
//               }
//         }
//     });
//     // document.getElementById('ResultadosBusqCrear_EO').style.display = 'none';
//     // document.getElementById('formEO').style.display = 'block';
//     // // formEO
//     // $("#formEO").load('app/EO/controlador/enlaces/formEO.php',{tipo: 'Crear',idUser: idUser,idPadron: idPadron, NomPadron: NomPadron});
//     // $("#formEO").show();
// }
// crear usuario padron
function createPA(){
    jQuery('#closeModalPA').click();
    var modal = UIkit.modal.blockUI('<div class=\'uk-text-center\'><br/><img class=\'uk-margin-top\' src=\'assets/img/spinners/spinner.gif\' alt=\'\'>');
    $.ajax({
        url: "app/EO/controlador/crear.php",
        type: "POST",
        data: {tipo: 'PadronNW'},
        success: function(data){
            $('#form1').html(data.options);
            if($('#form1').html()) {
                // console.log('Yes content');
                modal.hide();
              } else {          
                // console.log('No content');
                setTimeout(function(){
                    modal.hide(); 
                    alert("hubo un problema recarga la pagina");
                }, 10000);
              }
        }
    });
    // document.getElementById('ResultadosBusqCrear_PA').style.display = 'none';
    // document.getElementById('formPA').style.display = 'block';
    // // formPA
    // $("#formPA").load('app/EO/controlador/padron/formPA.php',{tipo: 'CrearUserPadron'});
    // $("#formPA").show();
}
// Seleccionar usuario padron
function UserSelect_PA(id,enlace) {
    jQuery('#closeModalPA').click();
    var modal = UIkit.modal.blockUI('<div class=\'uk-text-center\'><br/><img class=\'uk-margin-top\' src=\'assets/img/spinners/spinner.gif\' alt=\'\'>');
    $.ajax({
        url: "app/EO/controlador/crear.php",
        type: "POST",
        data: { idUser: id, tipo: 'PadronUP'},
        success: function(data){
            $('#form1').html(data.options);
            if($('#form1').html()) {
                // console.log('Yes content');
                modal.hide();
              } else {          
                // console.log('No content');
                setTimeout(function(){
                    modal.hide(); 
                    alert("hubo un problema recarga la pagina");
                }, 10000);
              }
        }
    });
}
// function FormPadDeNW(idPadon,IdUsuario,NomPadron) {
//     // var Proyecto = document.forms["formCrearEO"]["input_nombre_Proyecto_PA"].value;
//     var Nombre = document.forms["Crear_PadronDetalle_Form_NW"]["input_nombre_PA"].value;
//     var APP = document.forms["Crear_PadronDetalle_Form_NW"]["input_ape_pat_PA"].value;
//     var APM = document.forms["Crear_PadronDetalle_Form_NW"]["input_ape_mat_PA"].value;
//     var Direccion = document.forms["Crear_PadronDetalle_Form_NW"]["input_direccion_PA_nw"].value;
//     var cadena = document.forms["Crear_PadronDetalle_Form_NW"]["input_tel_PA"].value;
//     var Seccion = document.forms["Crear_PadronDetalle_Form_NW"]["input_Seccion_PA"].value;
//     var Correo = document.forms["Crear_PadronDetalle_Form_NW"]["input_email_PA"].value;
//     var Contraseña = document.forms["Crear_PadronDetalle_Form_NW"]["input_contraseña_PA"].value;
//     var
//     patron = / /g,
//     nuevoValor    = "",
//     Telefono = cadena.replace(patron, nuevoValor);
//     // alert("as");
//     $('#Crear_PadronDetalle_Form_NW').submit(function() {
//         $.ajax({
//             type: 'POST',
//             url: '',
//             data: '',
//             contentType: false,
//             processData: false,
//             success: function(data) {                
//                 // Guardar Datos     
//                 $("#resultadosContactos").load('app/EO/controlador/enlaces/acciones.php',{OPT: 'CrearPadronDetalleNW',idpadron: idPadon,idUser: IdUsuario,NomPadron: NomPadron,
//                 Nombre: Nombre, APP: APP, APM: APM,Direccion: Direccion, Telefono: Telefono,Correo: Correo, Contraseña: Contraseña, Seccion: Seccion});
//                 $("#resultadosContactos").show();
//             }
//         });
//         return false;
//     });
// }
// crear padron usuario activo
// function Crear_Padron(idEnlace,idUser) {
//     var Nombre = document.forms["Crear_Padron_Form"]["input_nombre_PA"].value;
//     var APP = document.forms["Crear_Padron_Form"]["input_ape_pat_PA"].value;
//     var APM = document.forms["Crear_Padron_Form"]["input_ape_mat_PA"].value;
//     var Direccion = document.forms["Crear_Padron_Form"]["input_direccion_PA_nw"].value;
//     var cadena = document.forms["Crear_Padron_Form"]["input_tel_PA"].value;
//     var NombrePadron = document.forms["Crear_Padron_Form"]["input_nombre_Padron"].value;
//     var Seccion = document.forms["Crear_Padron_Form"]["input_Seccion_PA"].value;
//     var Correo = document.forms["Crear_Padron_Form"]["input_email_PA"].value;
//     var Contraseña = document.forms["Crear_Padron_Form"]["input_contraseña_PA"].value;
//     var
//     patron = / /g,
//     nuevoValor    = "",
//     Telefono = cadena.replace(patron, nuevoValor);
//     // var modal;
//     // bloqueo();
//     // var modal = UIkit.modal.blockUI("Any content...");
//     // 
//     // (function(modal){ modal = UIkit.modal.blockUI('<div class=\'uk-text-center\'>Wait 5 sec...<br/><img class=\'uk-margin-top\' src=\'assets/img/spinners/spinner.gif\' alt=\'\'>'); setTimeout(function(){ modal.hide() }) })();
//     // modal = UIkit.modal.blockUI('<div class=\'uk-text-center\'><br/><img class=\'uk-margin-top\' src=\'assets/img/spinners/spinner.gif\' alt=\'\'>');
//     // Ikit.modal.blockUI(setTimeout(function(){ modal.hide() }, 5000));
//     $('#Crear_Padron_Form').submit(function() {
//         $.ajax({
//             type: 'POST',
//             url: '',
//             data: '',
//             contentType: false,
//             processData: false,
//             success: function(data) {    
//                 // modal.hide();
//                 // if ( modal.isActive() ) {
//                 //     modal.hide();
//                 // } else {
//                 //     modal.show();
//                 // }
//                 // setTimeout(function(){ 
//                 //     $("#resultados").load('app/EO/controlador/padron/acciones.php',{OPT: 'CrearPadronUpUser',id_enlace: idEnlace,NombrePadron: NombrePadron,
//                 //     idUser: idUser,Nombre: Nombre, APP: APP, APM: APM,Direccion: Direccion, Telefono: Telefono, Correo: Correo, Contraseña: Contraseña, Seccion: Seccion});
//                 //     $("#resultados").show();
//                 //     modal.hide();
//                 // }, 1000) ();
//                 // modal.close();
//                 // Guardar Datos                 
//                 // modal.UIkit.modal.blockUI(setTimeout(modal,0));
//                var m= document.getElementById("uk-modal uk-open");
//                m.classList.remove('show');
//                 // $('#ModalEnlaces').modal('hide');
//                 $("#resultados").load('app/EO/controlador/padron/acciones.php',{OPT: 'CrearPadronUpUser',id_enlace: idEnlace,NombrePadron: NombrePadron,
//                 idUser: idUser,Nombre: Nombre, APP: APP, APM: APM,Direccion: Direccion, Telefono: Telefono, Correo: Correo, Contraseña: Contraseña, Seccion: Seccion});
//                 $("#resultados").show();
//                 close();
//             }
//         });
//         // UIkit.modal.blockUI(setTimeout(function(){ modal.hide() }, 1000) ());
//         return false;
//     });
// }
// crear padron usuario nuevo
// function Crear_Padron_NwUser(idEnlace) {
//     var Nombre = document.forms["formCrearPA"]["input_nombre_PA"].value;
//     var APP = document.forms["formCrearPA"]["input_ape_pat_PA"].value;
//     var APM = document.forms["formCrearPA"]["input_ape_mat_PA"].value;
//     var Direccion = document.forms["formCrearPA"]["input_direccion_PA_nw"].value;
//     var cadena = document.forms["formCrearPA"]["input_tel_PA"].value;
//     var Seccion = document.forms["formCrearPA"]["input_Seccion_PA"].value;
//     var Correo = document.forms["formCrearPA"]["input_email_PA"].value;
//     var Contraseña = document.forms["formCrearPA"]["input_contraseña_PA"].value;
//     var NombrePadron = document.forms["formCrearPA"]["input_nombre_Padron"].value;
//     var
//     patron = / /g,
//     nuevoValor    = "",
//     Telefono = cadena.replace(patron, nuevoValor);
//     $('#formCrearPA').submit(function() {
//         $.ajax({
//             type: 'POST',
//             url: '',
//             data: '',
//             contentType: false,
//             processData: false,
//             success: function(data) {                
//                 // Guardar Datos                 
//                 $("#resultados").load('app/EO/controlador/padron/acciones.php',{OPT: 'CrearPadronUpUserNW',id_enlace: idEnlace,NombrePadron: NombrePadron,
//                 Nombre: Nombre, APP: APP, APM: APM,Direccion: Direccion, Telefono: Telefono,Correo: Correo, Contraseña: Contraseña, Seccion: Seccion});
//                 $("#resultados").show();
//             }
//         });
//         return false;
//     });
// }
function borrarPadron(idPadron,idResponasable,id_cambio){
    $("#resultados").load('app/EO/controlador/padron/acciones.php',{OPT: 'BorrarPadron',idPadron: idPadron, idResponasable: idResponasable, id_cambio: id_cambio});
    $("#resultados").show();
}
function PrincilaEnlace() {    
    principalDatos();
    $("#page_content").load('app/EO/vista/view_enlaces.php');
    $("#page_content").show();
}
function PrincipalDetalles(NombrePadron,padron) {
    principalDatos();
    $('#TablaPadron').load('app/EO/controlador/padron/tablaPrincipal.php');
    $("#TablaPadron").show();
    // 
    $("#Contactos_Tabla_PA").load('app/EO/vista/view_contactos.php',{nombre: NombrePadron, id :padron});
    $("#Contactos_Tabla_PA").show();
}
// function Crear_PadronDetalle(padron,usuario,NombrePadron) {
//     var Nombre = document.forms["Crear_PadronDetalle_Form"]["input_nombre_PA"].value;
//     var APP = document.forms["Crear_PadronDetalle_Form"]["input_ape_pat_PA"].value;
//     var APM = document.forms["Crear_PadronDetalle_Form"]["input_ape_mat_PA"].value;
//     var Direccion = document.forms["Crear_PadronDetalle_Form"]["input_direccion_PA_nw"].value;
//     var cadena = document.forms["Crear_PadronDetalle_Form"]["input_tel_PA"].value;
//     var Seccion = document.forms["Crear_PadronDetalle_Form"]["input_Seccion_PA"].value;
//     var Correo = document.forms["Crear_PadronDetalle_Form"]["input_email_PA"].value;
//     var Contraseña = document.forms["Crear_PadronDetalle_Form"]["input_contraseña_PA"].value;
//     // var NombrePadron = document.forms["Crear_PadronDetalle_Form"]["input_nombre_Padron"].value;
//     var
//     patron = / /g,
//     nuevoValor    = "",
//     Telefono = cadena.replace(patron, nuevoValor);
//     $('#Crear_PadronDetalle_Form').submit(function() {
//         $.ajax({
//             type: 'POST',
//             url: '',
//             data: '',
//             contentType: false,
//             processData: false,
//             success: function(data) {                
//                 // Guardar Datos                 
//                 $("#resultadosContactos").load('app/EO/controlador/enlaces/acciones.php',{OPT: 'CrearPadronDetalleUp',idpadron: padron,idUser: usuario,NombrePadron: NombrePadron,
//                 Nombre: Nombre, APP: APP, APM: APM,Direccion: Direccion, Telefono: Telefono,Correo: Correo, Contraseña: Contraseña, Seccion: Seccion});
//                 $("#resultadosContactos").show();
//             }
//         });
//         return false;
//     });
// }
// function borrarUserDetallePadron(id_usuario, idPadron,NombrePadron,id_cambio) {
//     $("#resultadosContactos").load('app/EO/controlador/enlaces/acciones.php',{OPT: 'borrarUserDetalle',id_User : id_usuario, id_cambio: id_cambio,idPadron:idPadron,NombrePadron:NombrePadron});
//     $("#resultadosContactos").show();
// }
function CrearPadrones(idPadron,Tipo) {
    Tipo_opt =Tipo;
    $("#page_content").load("app/EO/vista/view_agregar_Padron.php");
    $("#page_content").show();
    var modal = UIkit.modal.blockUI('<div class=\'uk-text-center\'><br/><img class=\'uk-margin-top\' src=\'assets/img/spinners/spinner.gif\' alt=\'\'>');
    $.ajax({
        url: "app/EO/controlador/crear.php",
        type: "POST",
        data: { idPadron: idPadron, tipo: Tipo_opt},
        success: function(data){
            $('#form1').html(data.options);
            if($('#form1').html()) {
                // console.log('Yes content');
                modal.hide();
              } else {          
                // console.log('No content'); //primero enlaces
                setTimeout(function(){
                    modal.hide(); 
                    alert("hubo un problema recarga la pagina");
                }, 10000);
              }
            // setTimeout(function(){
            //     modal.hide(); 
            // }, 1000);
        }
    });
}

// function CrearDetalle(idPadron,nombrePA,Tipo) {
//     Tipo_opt =Tipo;
//     $("#page_content").load("app/EO/vista/view_agregar_Detalle.php",{ idPadron: idPadron,nombrePA:nombrePA});
//     $("#page_content").show();
//     var modal = UIkit.modal.blockUI('<div class=\'uk-text-center\'><br/><img class=\'uk-margin-top\' src=\'assets/img/spinners/spinner.gif\' alt=\'\'>');
//     $.ajax({
//         url: "app/EO/controlador/enlaces/CrarDetalle.php",
//         type: "POST",
//         data: { idPadron: idPadron,nombrePA:nombrePA, tipo: Tipo_opt},
//         success: function(data){
//             $('#form1').html(data.options);
//             if($('#form1').html()) {
//                 // console.log('Yes content');
//                 modal.hide();
//               } else {          
//                 // console.log('No content');
//                 setTimeout(function(){
//                     modal.hide(); 
//                     alert("hubo un problema recarga la pagina");
//                 }, 10000);
//               }
//         }
//     });
//     // DetalleBL
// //     $("#ModalContactosEO").load("app/EO/controlador/enlaces/modalesEO.php",{idPadron: idPadron, tipo: Tipo_opt});
// //     $("#ModalContactosEO").show();
// }

function formSaveUserbtn() {
    // document.getElementById('GuardarPadron').disabled=true;
    var PA = document.forms["formSaveUser"]["input_nombre_Padron"].value;
    var Nombre = document.forms["formSaveUser"]["input_nombre_PA"].value;
    var APP = document.forms["formSaveUser"]["input_ape_pat_PA"].value;
    var APM = document.forms["formSaveUser"]["input_ape_mat_PA"].value;
    var Direccion = document.forms["formSaveUser"]["input_direccion_PA_nw"].value;
    var cadena = document.forms["formSaveUser"]["input_tel_PA"].value;
    var Seccion = document.forms["formSaveUser"]["input_Seccion_PA"].value;
    var Correo = document.forms["formSaveUser"]["input_email_PA"].value;
    var Contraseña = document.forms["formSaveUser"]["input_contraseña_PA"].value;    
    var idU = document.forms["formSaveUser"]["input_id"].value;  
    // var sexo = document.forms["formSaveUser"]["val_radio_male"].value; 
    var sexo = $('input[name="val_radio_gender"]:checked').val();
    var año = document.forms["formSaveUser"]["masked_date"].value;   
    var
    patron = / /g,
    nuevoValor    = "",
    Telefono = cadena.replace(patron, nuevoValor); 
    if(Nombre =="" || APP =="" ||PA =="" || Direccion =="" || Telefono =="" || Seccion =="" || Correo =="" || Contraseña =="" || año==""){
        // document.getElementById('GuardarPadron').disabled=false;
        // alert("faltan datos");        
        $('#resultados').html('<button class="md-btn" id="RespuestaCreateUserPadron" data-message="<a href=\'#\' class=\'notify-action\'  style=\'visibility: hidden;\'></a> faltan datos " data-status="danger" data-pos="top-center">Danger</button> <script> jQuery(function(){jQuery(\'#RespuestaCreateUserPadron\').click(); });    </script> ');
        $('#resultados').html('');
        $('#formSaveUser').submit(function() {
            event.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: '',
                        data: { tipo: 'AgregarUserPA'},
                        success: function(data){
                        }
                });
            return false;
        });
    }else{
        var modal = UIkit.modal.blockUI('<div class=\'uk-text-center\'><br/><img class=\'uk-margin-top\' src=\'assets/img/spinners/spinner.gif\' alt=\'\'>');
        $('#formSaveUser').submit(function() {
            // document.getElementById('GuardarPadron').disabled=false;
            event.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: 'app/EO/controlador/crear.php',
                        data: {tipo: 'AgregarUserPA',Accion:'Up',NomPadron: PA,Nombre: Nombre, APP: APP, APM: APM,Direccion: Direccion, Telefono: Telefono,Correo: Correo, Contraseña: Contraseña, Seccion: Seccion,idU: idU,sexo: sexo, nacimiento: año},
                        success: function(data){
                            $("#page_content").load('app/EO/vista/view_enlaces.php');
                            $("#page_content").show();
                            // modal.hide();
                            $('#resultados').html(data.options);
                            setTimeout(function(){
                                modal.hide(); 
                            }, 1000);
                        }
                        // error: function(data){
                        // 	//Cuando la interacción retorne un error, se ejecutará esto.
                        // }
                    // }
                });
                $("#page_content").load('app/EO/vista/view_enlaces.php');
                $("#page_content").show();
                // $('#resultados').html('<button class="md-btn" id="RespuestaCreateUserPadron" data-message="<a href=\'#\' class=\'notify-action\'></a>No se pudo registrar padron  " data-status="danger" data-pos="top-center">Danger</button> <script> jQuery(function(){jQuery(\'#RespuestaCreateUserPadron\').click(); });    </script> ');
                setTimeout(function(){
                    modal.hide(); 
                }, 1000);
            return false;
        });
    }
}
function formSaveDetallebtn(nombrePA,IdPA) {
    var PA = document.forms["formSaveDetalle"]["input_nombre_Padron"].value;
    var Nombre = document.forms["formSaveDetalle"]["input_nombre_PA"].value;
    var APP = document.forms["formSaveDetalle"]["input_ape_pat_PA"].value;
    var APM = document.forms["formSaveDetalle"]["input_ape_mat_PA"].value;
    var Direccion = document.forms["formSaveDetalle"]["input_direccion_PA_nw"].value;
    var cadena = document.forms["formSaveDetalle"]["input_tel_PA"].value;
    var Seccion = document.forms["formSaveDetalle"]["input_Seccion_PA"].value;
    var Correo = document.forms["formSaveDetalle"]["input_email_PA"].value;
    var Contraseña = document.forms["formSaveDetalle"]["input_contraseña_PA"].value;    
    var idU = document.forms["formSaveDetalle"]["input_id"].value;   
    var
    patron = / /g,
    nuevoValor    = "",
    Telefono = cadena.replace(patron, nuevoValor);
    if(Nombre =="" || APP =="" ||PA =="" || Direccion =="" || Telefono =="" || Seccion =="" || Correo =="" || Contraseña ==""){
        $('#resultados').html('<button class="md-btn" id="RespuestaCreateUserPadron" data-message="<a href=\'#\' class=\'notify-action\'  style=\'visibility: hidden;\'></a> faltan datos " data-status="danger" data-pos="top-center">Danger</button> <script> jQuery(function(){jQuery(\'#RespuestaCreateUserPadron\').click(); });    </script> ');
        $('#resultados').html('');
        $('#formSaveDetalle').submit(function() {
            event.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: '',
                        data: '',
                        success: function(data){
                        }
                });
            return false;
        });
    }else{
        var modal = UIkit.modal.blockUI('<div class=\'uk-text-center\'><br/><img class=\'uk-margin-top\' src=\'assets/img/spinners/spinner.gif\' alt=\'\'>');
        $('#formSaveDetalle').submit(function() {
            event.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: 'app/EO/controlador/enlaces/CrarDetalle.php',
                        data: {tipo: 'AgregarUserDetalle',idpadron: IdPA,NomPadron: PA,Nombre: Nombre, APP: APP, APM: APM,Direccion: Direccion, Telefono: Telefono,Correo: Correo, Contraseña: Contraseña, Seccion: Seccion,idU: idU},
                        success: function(data){
                            // $("#page_content").load('app/EO/vista/view_enlaces.php');
                            // $("#page_content").show();
                            // modal.hide();
                            $('#resultados').html(data.options);
                            setTimeout(function(){
                                modal.hide(); 
                            }, 1000);
                            PrincipalDetalles(PA,IdPA);
                            //   PrincipalDetalles(nombrepadron,idpadron);
                            // $("#Contactos_Tabla_PA").load('app/EO/vista/view_contactos.php',{nombre: 'prueba usuario nuevo', id :'55'});
                            // $("#Contactos_Tabla_PA").show();
                        }
                });
                $("#page_content").load('app/EO/vista/view_enlaces.php');
                $("#page_content").show();
                setTimeout(function(){
                    modal.hide(); 
                }, 1000);
            return false;
        });
    }
}
function formoperadorbtn() {
    // document.getElementById('GuardarPadron').disabled=true;
    // var PA = document.forms["formoperador"]["input_nombre_Padron"].value;
    var Nombre = document.forms["formoperador"]["input_nombre_PA"].value;
    var APP = document.forms["formoperador"]["input_ape_pat_PA"].value;
    var APM = document.forms["formoperador"]["input_ape_mat_PA"].value;
    var Direccion = document.forms["formoperador"]["input_direccion_PA_nw"].value;
    var cadena = document.forms["formoperador"]["input_tel_PA"].value;
    var Seccion = document.forms["formoperador"]["input_Seccion_PA"].value;
    var Correo = document.forms["formoperador"]["input_email_PA"].value;
    var Contraseña = document.forms["formoperador"]["input_contraseña_PA"].value;    
    var idU = document.forms["formoperador"]["input_id"].value; 
    // var sexo = document.forms["formoperador"]["val_radio_male"].value; 
    var año = document.forms["formoperador"]["masked_date"].value;   
    var sexo = $('input[name="val_radio_gender"]:checked').val();
    var
    patron = / /g,
    nuevoValor    = "",
    Telefono = cadena.replace(patron, nuevoValor); 
    alert( sexo);        
    if(Nombre =="" || APP =="" || Seccion =="" || Correo =="" || Contraseña =="" || año==""){
        // document.getElementById('GuardarPadron').disabled=false;
        $('#resultados').html('<button class="md-btn" id="RespuestaCreateUserPadron" data-message="<a href=\'#\' class=\'notify-action\'  style=\'visibility: hidden;\'></a> faltan datos " data-status="danger" data-pos="top-center">Danger</button> <script> jQuery(function(){jQuery(\'#RespuestaCreateUserPadron\').click(); });    </script> ');
        $('#resultados').html('');
        $('#formoperador').submit(function() {
            event.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: '',
                        data: { tipo: 'AgregarOperador'},
                        success: function(data){
                        }
                });
            return false;
        });
    }else{
        var modal = UIkit.modal.blockUI('<div class=\'uk-text-center\'><br/><img class=\'uk-margin-top\' src=\'assets/img/spinners/spinner.gif\' alt=\'\'>');
        $('#formoperador').submit(function() {
            // document.getElementById('GuardarPadron').disabled=false;
            event.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: 'app/EO/controlador/crear.php',
                        data: {tipo: 'AgregarOperador',Accion:'Padron',NomPadron: PA,Nombre: Nombre, APP: APP, APM: APM,Direccion: Direccion, Telefono: Telefono,Correo: Correo, Contraseña: Contraseña, Seccion: Seccion,idU: idU,sexo: sexo, nacimiento: año},
                        success: function(data){
                            $("#page_content").load('app/EO/vista/view_Operador.php');
                            $("#page_content").show();
                            // modal.hide();
                            $('#resultados').html(data.options);
                            setTimeout(function(){
                                modal.hide(); 
                            }, 1000);
                        }
                        // error: function(data){
                        // 	//Cuando la interacción retorne un error, se ejecutará esto.
                        // }
                    // }
                });
                $("#page_content").load('app/EO/vista/view_Operador.php');
                $("#page_content").show();
                // $('#resultados').html('<button class="md-btn" id="RespuestaCreateUserPadron" data-message="<a href=\'#\' class=\'notify-action\'></a>No se pudo registrar padron  " data-status="danger" data-pos="top-center">Danger</button> <script> jQuery(function(){jQuery(\'#RespuestaCreateUserPadron\').click(); });    </script> ');
                setTimeout(function(){
                    modal.hide(); 
                }, 1000);
            return false;
        });
    }
}
function modal_CreatePadron() {
    $("#ModalCrearContacEO").load("app/EO/controlador/crear.php",{idPadron: '0', tipo: 'BusquedaUserPadron'});
    $("#ModalCrearContacEO").show();    
}
function modal_CreateOperador() {
    $("#ModalCrearOperadorEO").load("app/EO/controlador/crear.php",{idPadron: '0', tipo: 'BusquedaUserOperador'});
    $("#ModalCrearOperadorEO").show();    
}
function modal_CreateDetalle(){
    $("#ModalCrearDetalleEO").load("app/EO/controlador/enlaces/CrarDetalle.php",{tipo: 'BusquedaDetalle'});
    $("#ModalCrearDetalleEO").show(); 
}
function regresar2(ruta,nombrepadron,){
    $("#page_content").load(ruta);
    $("#page_content").show();
    // PrincipalDetalles(nombrepadron,idpadron);
    // principalDatos();
    // $('#TablaPadron').load('app/EO/controlador/padron/tablaPrincipal.php');
    // $("#TablaPadron").show();
    // // // 
    // $("#Contactos_Tabla_PA").load('app/EO/vista/view_contactos.php',{nombre: nombrepadron, id : 1});
    // $("#Contactos_Tabla_PA").show();
}
function regresar(ruta){
    $("#page_content").load(ruta);
    $("#page_content").show();
}
