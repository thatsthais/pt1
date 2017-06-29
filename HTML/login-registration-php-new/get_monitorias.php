<?php
	require_once 'dbconnect.php';


	$return_ajax = '{"data": [';

	$fetch = mysql_query("SELECT * FROM reservas INNER JOIN disciplina ON reservas.disciplina_fk = disciplina.codigo ORDER BY idreserva DESC");


    while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC))
    {
		$return_ajax = $return_ajax . '[';

		$date_start = strtotime($row['date_start']);
		$date_start = date('d/m/Y H:i', $date_start);

		$date_end = strtotime($row['date_end']);
		$date_end = date('d/m/Y H:i', $date_end);

		$disciplina = $row['nome'];

		$date = $date_start . ' até ' . $date_end;


		$return_ajax = $return_ajax . '"' . $row['idreserva'] . '",';
		$return_ajax = $return_ajax . '"' . $disciplina . '",';
		$return_ajax = $return_ajax . '"' . $row['local'] . '",';
		$return_ajax = $return_ajax . '"' . $date . '"';

		$return_ajax = $return_ajax . '],';

    }

	$return_ajax = rtrim($return_ajax,",");
	$return_ajax = $return_ajax . ']}';

    echo $return_ajax;

?>
