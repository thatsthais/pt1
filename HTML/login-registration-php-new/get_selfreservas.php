<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';

	if(!isset($_SESSION['user'])){
        header("Location: index.html");
    }
	else
	{
		$user = $_SESSION['user'];

		$return_ajax = '{"data": [';

		$fetch = mysql_query("SELECT * FROM reservas INNER JOIN users ON reservas.user_fk = users.userRegistration INNER JOIN disciplina ON reservas.disciplina_fk = disciplina.codigo WHERE users.userRegistration=$user ORDER BY accepted ASC");


	    while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC))
	    {
			$return_ajax = $return_ajax . '[';

			if($row['monitoria'] == 0)
			{
				$monitoria = 'Não';
			}
			else
			{
				$monitoria = 'Sim' . ' (' . $row['nome'] . ')';
			}

			$date_start = strtotime($row['date_start']);
			$date_start = date('d/m/Y H:i', $date_start);

			$date_end = strtotime($row['date_end']);
			$date_end = date('d/m/Y H:i', $date_end);


			$date = $date_start . ' até ' . $date_end;


			$return_ajax = $return_ajax . '"' . $row['idreserva'] . '",';
			$return_ajax = $return_ajax . '"' . $row['accepted'] . '",';
			$return_ajax = $return_ajax . '"' . $row['local'] . '",';
			$return_ajax = $return_ajax . '"' . $date . '",';
			$return_ajax = $return_ajax . '"' . $monitoria . '",';
			$return_ajax = $return_ajax . '"' . $row['description'] . '"';

			$return_ajax = $return_ajax . '],';

	    }

		$return_ajax = rtrim($return_ajax,",");
		$return_ajax = $return_ajax . ']}';

	    echo $return_ajax;
	}

?>
