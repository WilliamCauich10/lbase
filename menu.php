<link rel="stylesheet" type="text/css" href="assets/css/menu.css">
<!-- <ul> -->
<?php 
$v=0;
	$Perfil = $_SESSION['tipo_usuario'];
    $stmt = $pdo -> prepare("SELECT Id_Modelo, Perfil_Usuario, ID_Padre, Nombre_Modelo, Icono_Modelo, Ruta, Status FROM modelo where Perfil_Usuario = '$Perfil' AND ID_Padre=0 order by orden");
    $execute = $stmt -> execute();
        if($execute === true):
        	while( $row = $stmt -> fetch()){ 
                if ($row['Status']==0) {  
                    if ($v==0) {?>
                    <a id="<?= $row['Id_Modelo'] ?>"  class="active" onclick="CargarPaginas('<?= $row['Ruta'] ?>');Menu('<?= $row['Id_Modelo'] ?>')" ><?= $row['Nombre_Modelo']; ?></a>
<?php
                    }else{
                    ?>
                    <!-- <li> id="active" -->

                        <a id="<?= $row['Id_Modelo'] ?>"  class="Menu_" onclick="CargarPaginas('<?= $row['Ruta'] ?>');Menu('<?= $row['Id_Modelo'] ?>')" ><?= $row['Nombre_Modelo']; ?></a>
                    <!-- </li> -->
                    
                  
                    <?php           }
           }//if
				else{ ?>
                    <button class="dropdown-btn"><?= $row['Nombre_Modelo']; ?>
                        <i class="fa fa-caret-down"></i>
                    </button>
					<div class="dropdown-container">
	                <?php
                    $IdMod = $row['Id_Modelo'];
                        $Results = $pdo -> prepare("SELECT Id_Modelo, Perfil_Usuario, ID_Padre, Nombre_Modelo, Icono_Modelo, Ruta, Status FROM modelo where Perfil_Usuario = '$Perfil' AND ID_Padre=$IdMod  order by orden");
                     $execute2 = $Results -> execute();
                      while( $row2 = $Results -> fetch()){ // ul li
                    ?>
                     
                        <a onclick="CargarPaginas('<?= $row2['Ruta'] ?>')"><?= $row2['Nombre_Modelo']; ?></a>
                            <!--  -->
<?php               }//while2
?>
                      </div>
<?php
                }//else
                $v++;
			}//while
        endif;
?>
  <!-- </ul> -->