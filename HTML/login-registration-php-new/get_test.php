<?php
	require_once 'dbconnect.php';

	$local = '';
	$class = '';
	if (isset($_GET['local'])) {
    	$local = mysql_real_escape_string($_GET['local']);
	}

	if (isset($_GET['class'])) {
    	$class = mysql_real_escape_string($_GET['class']);
	}

    $return_arr = array();

	if($local == '')
	{
		if($class == '')
		{
			$fetch=mysql_query("SELECT * FROM horario INNER JOIN turma ON horario.turma_fk = turma.turma_pk INNER JOIN disciplina ON turma.disciplina = disciplina.codigo");
		}
		else
		{
			$fetch=mysql_query("SELECT * FROM horario INNER JOIN turma ON horario.turma_fk = turma.turma_pk INNER JOIN disciplina ON turma.disciplina = disciplina.codigo WHERE disciplina.nome = '$class'");
		}
	}
	else
	{
		if($class == '')
		{
			$fetch=mysql_query("SELECT * FROM horario INNER JOIN turma ON horario.turma_fk = turma.turma_pk INNER JOIN disciplina ON turma.disciplina = disciplina.codigo WHERE turma.local = '$local'") or die (mysql_error());
		}
		else
		{
			$fetch=mysql_query("SELECT * FROM horario INNER JOIN turma ON horario.turma_fk = turma.turma_pk INNER JOIN disciplina ON turma.disciplina = disciplina.codigo WHERE turma.local = '$local' AND disciplina.nome = '$class'") or die (mysql_error());
		}
	}

    while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC))
    {
        $startDate = '2017-01-01';
        $endDate = '2017-07-07s';
        $endDate = strtotime($endDate);

        if($row['dia'] == 'S'):
            $beginDate = strtotime('Sunday', strtotime($startDate));
        elseif ($row['dia'] == 'M'):
            $beginDate = strtotime('Monday', strtotime($startDate));
        elseif ($row['dia'] == 'T'):
            $beginDate = strtotime('Tuesday', strtotime($startDate));
        elseif ($row['dia'] == 'W'):
            $beginDate = strtotime('Wednesday', strtotime($startDate));
        elseif ($row['dia'] == 'R'):
            $beginDate = strtotime('Thursday', strtotime($startDate));
        elseif ($row['dia'] == 'F'):
            $beginDate = strtotime('Friday', strtotime($startDate));
        elseif ($row['dia'] == 'U'):
            $beginDate = strtotime('Saturday', strtotime($startDate));
        endif;

        for($i = $beginDate; $i <= $endDate; $i = strtotime('+1 week', $i))
        {
            $row_array['title'] = $row['nome'];
            $row_array['start'] = date('Y-m-d', $i) . 'T' . $row['hora_inicio'];
            $row_array['end'] = date('Y-m-d', $i) . 'T' . $row['hora_fim'];
			$row_array['location'] = $row['local'];
            array_push($return_arr,$row_array);
        }
    }

	if($class == "")
	{
		if($local == "")
		{
			$fetch=mysql_query("SELECT * FROM reservas INNER JOIN disciplina ON reservas.disciplina_fk = disciplina.codigo WHERE accepted = 1") or die (mysql_error());
		}
		else
		{
			$fetch=mysql_query("SELECT * FROM reservas INNER JOIN disciplina ON reservas.disciplina_fk = disciplina.codigo WHERE accepted = 1 AND reservas.local = '$local'") or die (mysql_error());
		}

		while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC))
	    {
			if($row['monitoria'] == 1)
			{
				$row_array['title'] = 'MONITORIA: ' . $row['nome'];
			}
			else
			{
				$row_array['title'] = 'RESERVADA';
			}
	        $row_array['start'] = $row['date_start'];
			$row_array['end'] = $row['date_end'];
			$row_array['location'] = $row['local'];

	        array_push($return_arr,$row_array);
	    }
	}



    echo json_encode($return_arr);



?>
