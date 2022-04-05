<?php 
    if(unlink("../uploads/1.jpeg")){
        echo "OK";
    }else{
        echo "ERROR";
    }
?>