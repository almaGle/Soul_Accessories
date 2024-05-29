<?php
$bd=new mysqli("localhost", "root", "", "proyecto");
if($bd){
    echo "hay conexion";
}else{
    echo "no hay conexion";
}
