<?php
    ob_start();
	session_start();
    if( isset($_SESSION['user'])!="" ){
        header("Location: index.php");
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

        $terms = trim($_POST['terms']);
        $terms = strip_tags($terms);
        $terms = htmlspecialchars($terms);



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
                sleep(5);
                if($usertype == 0)
                {
                    // Student
                    unset($usertype);
                    header('Location: aluno.php');
                }
                else
                {
                    // Teacher
                    unset($usertype);
                	header('Location: professor.php');
                }
            } else {
                $errTyp = "danger";
                $errMSG = "Algo está errado, tente novamente mais tarde...";
            }

        }


    }
?>
<!DOCTYPE html>
<!--[if IE 8]>          <html class="ie ie8"> <![endif]-->
<!--[if IE 9]>          <html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->  <html> <!--<![endif]-->
<head>
      <meta charset="utf-8">
      <title>ReservENE</title>
      <meta name="description" content="ReservENE">
      <meta name="author" content="UnB">
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- Google Fonts -->
      <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Raleway:400,500,600,700' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
      <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine" />
      <!-- Library CSS -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="css/bootstrap-theme.min.css">
      <link rel="stylesheet" href="css/team-member.css" media="screen">
      <link rel="stylesheet" href="css/fonts/font-awesome/css/font-awesome.css">
      <link rel="stylesheet" href="css/animations.css" media="screen">
      <link rel="stylesheet" href="css/prettyPhoto.css" media="screen">
      <link rel="stylesheet" href="css/jquery.bxslider.css" media="screen">
      <!-- Theme CSS -->
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="css/global.css">
      <!-- Skin -->
      <link rel="stylesheet" href="css/colors/blue.css" class="colors">


      <!-- Favicons -->
      <link rel="shortcut icon" href="img/ico/favicon.ico">
      <link rel="apple-touch-icon" href="img/ico/apple-touch-icon.png">
      <link rel="apple-touch-icon" sizes="72x72" href="img/ico/apple-touch-icon-72.png">
      <link rel="apple-touch-icon" sizes="114x114" href="img/ico/apple-touch-icon-114.png">
      <link rel="apple-touch-icon" sizes="144x144" href="img/ico/apple-touch-icon-144.png">
      <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
      <!--[if lt IE 9]>
     <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
     <script src="js/respond.min.js"></script>
     <![endif]-->
      <!--[if IE]>
     <link rel="stylesheet" href="css/ie.css">
     <![endif]-->
</head>
<body data-spy="scroll" data-target="#navigation" data-offset="75">
      <!-- Page Preloader -->
       <div class="page-mask">
            <div class="page-loader">

                <div class=""></div>
            </div>
      </div>
      <!-- /Page Preloader -->

      <!-- Warpper -->
      <div class="wrap with-logo">

            <!--/Image Background Parallax -->

            <!-- Header -->
            <header id="section1" class="parallax-slider">

                  <!-- Navigation -->
                  <div id="navigation">
                        <nav class="navbar navbar-custom cl-effect-21" role="navigation">
                              <div class="container">
                                    <div class="row">
                                          <div class="col-md-2 mob-logo">
                                                <div class="row">
                                                      <div class="site-logo">
                                                            <a href="index.php"><img src="logo1.png" alt="ReservENE"></a>
                                                      </div>
                                                </div>
                                          </div>


                                          <div class="col-md-10 mob-menu">
                                                <div class="row">
                                                      <!-- Brand and toggle get grouped for better mobile display -->
                                          <div class="navbar-header">
                                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
                                                <i class="fa fa-bars"></i>
                                                </button>
                                          </div>
                                                      <!-- Collect the nav links, forms, and other content for toggling -->
                                                      <div class="collapse navbar-collapse" id="menu">
                                                            <ul class="nav navbar-nav navbar-right">
                                                                  <li><a href="calendar.html" onclick="location.href='calendar.html'">Mapa de Salas</a></li>
                                                                  <li><a href="login.php" onclick="location.href='login.php'">Login</a></li>
                                                                  <li><a href="register.php" onclick="location.href='register.php'">Cadastro</a></li>
                                                            </ul>
                                                      </div>
                                                      <!-- /.Navbar-collapse -->
                                                </div>
                                          </div>
                                    </div>
                              </div>
                              <!-- /.container -->
                        </nav>
                  </div>
                  <!-- /Navigation -->
            </header>
            <!-- /Header -->

            <!-- Section 2 -->

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


			  			<input type="radio" name="usertype" value="0" checked> ALUNO</input>
                        <div class="col-md-6">
                            <input type="radio" name="terms" value="0" checked> Li e concordo com os <a target="_blank" href="termos-de-uso.pdf">termos de uso.</a><br>
                        </div>
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
			            	<a href="login.php">Já tenho cadastro...</a>
			            </div>

			        </div>

			    </form>
			    </div>

			</div>

			</body>
			<?php ob_end_flush(); ?>


                  <!-- Google Map -->
                  <!-- <div class="mapouter"><div class="gmap_canvas">
                     <iframe width="2000" height="300" id="gmap_canvas" style="pointer-events:none" src="https://maps.google.com/maps?q=Faculdade%20de%20Tecnologia&t=&z=17&ie=UTF8&iwloc=&output=embed"
                     frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
                 </iframe>google map <a href="http://www.embedgooglemap.net">embedgooglemap.net</a></div>
                 <style>.mapouter{overflow:hidden;height:300px;width:2000px;}.gmap_canvas {background:none!important;height:300px;width:2000px;}
                     </style>
                 </div> -->
                  <!-- /Google Map -->

				  <footer class="footer-wrap text-center">
			          <div class="row" id="row-footer">
			             <div class="col-md-20" id="local">
			                <a id="rodape" onclick="localizacao_unb()" role="button"><i class="fa fa-map-marker"></i></a>
			                <p><a id="rodape-unb" onclick="localizacao_unb()" role="button"><span id="unb-footer">Universidade de Brasília</span> - Brasília, DF</a></p>
			                <div id="email">
			                   <a href="mailto:reservene@gmail.com"><i class="fa fa-envelope"></i></a>
			                   <p><a href="mailto:reservene@gmail.com" role="button">reservene@gmail.com</a></p>
			                   <a href="termos-de-uso.pdf" id="politica" target="_blank">
			                      <p class="footer-unba-alerta">Política de Privacidade</p>
			                   </a>
			                </div>
			             </div>
			          </div>

			                <div class="modal-footer">Equipe Projeto Transversal B © 2017</div>
			          </footer>
            </section>
            <!-- /Section 7 -->

            <!-- Scroll To Top -->
            <a href="#" class="scrollup"><i class="fa fa-angle-up"></i></a>
      </div>
      <!-- /Warpper -->



      <!-- The Scripts -->
      <script src="js/jquery.min.js"></script>
      <script src="js/jquery-migrate-1.0.0.js"></script>
      <script src="js/jquery-ui.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/jquery.parallax.js"></script>
      <script src="js/jquery.hparallax.js"></script>
      <script src="js/jquery.wait.js"></script>
      <script src="js/appear.js"></script>
      <script src="js/fappear.js"></script>
      <script src="js/modernizr-2.6.2.min.js"></script>
      <script src="js/jquery.bxslider.min.js"></script>
      <script src="js/jquery.maximage.js"></script>
      <script src="js/jquery.cycle.all.js"></script>
      <script src="js/jquery.prettyPhoto.js"></script>
      <script src="js/jquery.sticky.js"></script>
      <script src="js/jquery.isotope.js"></script>
      <script src="js/imagesloaded.pkgd.min.js"></script>
      <script src="js/jquery.countTo.js"></script>
      <script src="js/skrollr.min.js"></script>
      <script src="js/jquery.scrollTo.min.js"></script>
      <script src="js/jquery.nav.js"></script>
      <script src="js/wow.js"></script>
      <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
      <script src="js/jquery.gmap.min.js"></script>
      <script src="js/jquery.mb.YTPlayer.js"></script>
      <script src="js/tytabs.js"></script>
      <script src="js/custom.js"></script>

</body>
</html>
