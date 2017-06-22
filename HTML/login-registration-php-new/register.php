<?php
	ob_start();
	session_start();
	if( isset($_SESSION['user'])!="" ){
		header("Location: home.php");
	}
	include_once 'dbconnect.php';

	$error = false;

	if ( isset($_POST['btn-signup']) ) {

		// clean user inputs to prevent sql injections
		$name = trim($_POST['name']);
		$name = strip_tags($name);
		$name = htmlspecialchars($name);

		$registration = trim($_POST['registration']);
		$registration = strip_tags($registration);
		$registration = htmlspecialchars($registration);

		$email = trim($_POST['email']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email);

		$pass = trim($_POST['pass']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);


		$usertype = trim($_POST['usertype']);
		$usertype = strip_tags($usertype);
		$usertype = htmlspecialchars($usertype);



		// basic name validation
		if (empty($name)) {
			$error = true;
			$nameError = "Por favor, digite seu nome completo.";
		} else if (strlen($name) < 5) {
			$error = true;
			$nameError = "Nome deve conter pelo menos 5 caracteres.";
		} else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
			$error = true;
			$nameError = "Nome deve conter letras e espaços.";
		}

		//basic email validation
		if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$error = true;
			$emailError = "Por favor, digite um email válido.";
		} else {
			// check email exist or not
			$query = "SELECT userEmail FROM users WHERE userEmail='$email'";
			$result = mysql_query($query);
			$count = mysql_num_rows($result);
			if($count!=0){
				$error = true;
				$emailError = "O email digitado já está sendo usado.";
			}
		}
		// matricula validation
		if (empty($registration)){
			$error = true;
			$registrationError = "Por favor, digite a matrícula.";
		} else if(strlen($registration) < 9) {
			$error = true;
			$registrationError = "Matrícula deve conter 9 dígitos.";
		}
		// password validation
		if (empty($pass)){
			$error = true;
			$passError = "Por favor, digite a senha.";
		} else if(strlen($pass) < 6) {
			$error = true;
			$passError = "A senha deve conter pelo menos 6 caracteres.";
		}

		// password encrypt using SHA256();
		$password = hash('sha256', $pass);

		// if there's no error, continue to signup
		if( !$error ) {

			$query = "INSERT INTO users(userRegistration, userName, userEmail, userPass, userType) VALUES('$registration', '$name', '$email', '$password', '$usertype')";
			$res = mysql_query($query) or die(mysql_error($conn));

			if ($res) {
				$errTyp = "success";
				$errMSG = "Cadastro realizado com sucesso!";
				unset($registration);
				unset($name);
				unset($email);
				unset($pass);
				unset($usertype);
			} else {
				$errTyp = "danger";
				$errMSG = "Algo está errado, tente novamente mais tarde...";
			}

		}


	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cadastro</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<div class="container">

	<div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

    	<div class="col-md-12">

        	<div class="form-group">
            	<h2 class="">Cadastre-se.</h2>
            </div>

        	<div class="form-group">
            	<hr />
            </div>

            <?php
			if ( isset($errMSG) ) {

				?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php
			}
			?>
			<div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input type="text" name="registration" class="form-control" placeholder="Entre com a matrícula" maxlength="9" value="<?php echo $registration ?>" />
                </div>
                <span class="text-danger"><?php echo $registrationError; ?></span>
            </div>

            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input type="text" name="name" class="form-control" placeholder="Entre com o nome" maxlength="50" value="<?php echo $name ?>" />
                </div>
                <span class="text-danger"><?php echo $nameError; ?></span>
            </div>

            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
            	<input type="email" name="email" class="form-control" placeholder="Entre com o email" maxlength="40" value="<?php echo $email ?>" />
                </div>
                <span class="text-danger"><?php echo $emailError; ?></span>
            </div>

            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
            	<input type="password" name="pass" class="form-control" placeholder="Entre com a senha" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>


  			<input type="radio" name="usertype" value="0" checked> ALUNO<br>
  			<input type="radio" name="usertype" value="1"> PROFESSOR<br>



            <div class="form-group">
            	<hr />
            </div>

            <div class="form-group">
            	<button type="submit" class="btn btn-block btn-primary" name="btn-signup">Cadastrar</button>
            </div>

            <div class="form-group">
            	<hr />
            </div>

            <div class="form-group">
            	<a href="index.php">Já tenho cadastro...</a>
            </div>

        </div>

    </form>
    </div>

</div>

</body>
</html>
<?php ob_end_flush(); ?>
