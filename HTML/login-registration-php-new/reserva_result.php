<?php
    ob_start();
    session_start();
    include_once 'dbconnect.php';

    if( isset($_SESSION['user']) == "" ){
        header("Location: index.html");
    }
    else
    {
        $option = trim($_POST["option"]);
        $option = trim($option, '""');
        $option = strip_tags($option);
        $option = htmlspecialchars($option);

        $pk = trim($_POST["pk"]);
        $pk = trim($pk, '""');
        $pk = strip_tags($pk);
        $pk = htmlspecialchars($pk);

        $query = "UPDATE reservas SET accepted=$option WHERE idreserva = $pk";
        echo $query;
        $res = mysql_query($query) or die(mysql_error($conn));

    }

?>
