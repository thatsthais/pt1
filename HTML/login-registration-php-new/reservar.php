<?php
    ob_start();
    session_start();
    include_once 'dbconnect.php';

    if( isset($_SESSION['user']) == "" ){
        header("Location: index.php");
    }
    else
    {
        $monitoria = trim($_POST["monitoria"]);
        $monitoria = trim($monitoria, '""');
        $monitoria = strip_tags($monitoria);
        $monitoria = htmlspecialchars($monitoria);

        $local = trim($_POST["location"]);
        $local = trim($local, '""');
        $local = strip_tags($local);
        $local = htmlspecialchars($local);

        $class = trim($_POST["class"]);
        $class = trim($class, '""');
        $class = strip_tags($class);
        $class = htmlspecialchars($class);

        $query = mysql_query("SELECT codigo FROM disciplina WHERE nome='$class' LIMIT 1");
        $res = mysql_fetch_assoc($query) or die(mysql_error($conn));

        if($res)
        {
            $class = $res['codigo'];

            $description = trim($_POST["description"]);
            $description = trim($description, '""');
            $description = strip_tags($description);
            $description = htmlspecialchars($description);

            $start = trim($_POST["start"], '""');
            $start = date("Y-m-d H:i:s", strtotime($start));

            $end = trim($_POST["end"], '""');
            $end = date("Y-m-d H:i:s", strtotime($end));

            $user = $_SESSION['user'];
            $query = "INSERT INTO reservas(monitoria, date_start, date_end, local, description, user_fk, disciplina_fk) VALUES('$monitoria', '$start', '$end', '$local', '$description', '$user', '$class' )";
            $res = mysql_query($query) or die(mysql_error($conn));
        }



    }

?>
