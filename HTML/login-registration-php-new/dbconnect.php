<?php

	// this will avoid mysql_connect() deprecation error.
	error_reporting( ~E_DEPRECATED & ~E_NOTICE );
	// but I strongly suggest you to use PDO or MySQLi.

	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	//define('DBNAME', 'mw');
	define('DBNAME', 'dbmw');

	$conn = mysql_connect(DBHOST,DBUSER,DBPASS);
	$dbcon = mysql_select_db(DBNAME);

	if ( !$conn ) {
		die("Conexão falhou: " . mysql_error());
	}

	if ( !$dbcon ) {
		die("Conexão com o banco de dados falhou: " . mysql_error());
	}
