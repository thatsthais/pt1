
<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';

	// if session is not set this will redirect to login page
//	if( !isset($_SESSION['user']) ) {
///		header("Location: index.php");
//		exit;
//	}
	// select loggedin users detail
//	$res=mysql_query("SELECT * FROM users WHERE userRegistration=".$_SESSION['user']);
//	$userRow=mysql_fetch_array($res);


	// A sessão precisa ser iniciada em cada página diferente
	if (!isset($_SESSION)) session_start();

	// Verifica se não há a variável da sessão que identifica o usuário
	if (!isset($_SESSION['user'])) {
		// Destrói a sessão por segurança
		session_destroy();
		// Redireciona o visitante de volta pro login
		header("Location: login.php"); exit;
	}
	$user = $_SESSION['user'];

	$query = mysql_query("SELECT userType FROM users WHERE userRegistration = $user");
	$row = mysql_fetch_array($query);
	if($row['userType'] != 1)
	{
		session_destroy();
		// Redireciona o visitante de volta pro login
		header("Location: login.php"); exit;
	}
?>
<!DOCTYPE html>
<html>
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
	<link rel='stylesheet' href='js/lib/cupertino/jquery-ui.min.css' />
	<link href='css/fullcalendar.min.css' rel='stylesheet' />
	<link href='css/fullcalendar.print.min.css' rel='stylesheet' media='print' />
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
   <style>

   	#calendar {
   		max-width: 900px;
   		margin: 0 auto;
   	}

   </style>
</head>

<script src="js/jquery.min.js"></script>
<script src='js/lib/moment.min.js'></script>
<script src='js/fullcalendar.min.js'></script>
<script src='js/locale/pt-br.js'></script>
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
<script>

	$(document).ready(function() {

		$('#calendar').fullCalendar({
			timezone: 'local',
			minTime: "08:00:00",
			maxTime: "20:00:00",
			defaultView: 'agendaWeek',
			defaultEventMinutes: 120,
			selectable: 'true',
			selectHelper: 'true',
			theme: true,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'agendaWeek,agendaDay,listMonth'
			},

			select: function(start, end, allDay)
			{
				end =  $.fullCalendar.moment(start);
				end.add(110, 'minutes');
				/*
					after selection user will be promted for enter title for event.
				*/

				/*
					if title is enterd calendar will add title and event into fullCalendar.
			*/
			$('#calendar').fullCalendar('renderEvent',
			{
				start: start,
				end: end,
				allDay: false
				},
				false // stick the event
			);

			$("#myModalForm").modal();

			$( "#btnSubmitModal" ).click(function() {
			  var monitoria = $('input[name=monitoria]:checked').val();
			  var description = $("#description").val();
			  var location = $("#location").val();
			  var selected_class = $("#selected_class").val();
			  var start_date = moment(start.format('YYYY/MM/DD HH:mm:ss')).format("YYYY-MM-DD HH:mm:ss");
			  var end_date = moment(end.format('YYYY/MM/DD HH:mm:ss')).format("YYYY-MM-DD HH:mm:ss");

			  $.post('reservar.php', {start: JSON.stringify(start_date), end: JSON.stringify(end_date), monitoria: JSON.stringify(monitoria), class: JSON.stringify(selected_class), location: JSON.stringify(location), description: JSON.stringify(description)})
		  });

		  	$('#calendar').fullCalendar("refetchEvents");

			},
			navLinks: true, // can click day/week names to navigate views
			eventLimit: true, // allow "more" link when too many events
			events: {
				url: 'http://localhost/projetotransversal1/HTML/login-registration-php-new/get_test.php',
				data: function() {
					return {
						'local': $('#location').val(),
						'class': $('#class').val(),
					}
				}
			}
		});

		$('#location').on('change', function() {
		  $('#calendar').fullCalendar('refetchEvents');
		})
		$('#class').on('change', function() {
		  $('#calendar').fullCalendar('refetchEvents');
		})

	});


</script>
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
                                                            <a href="aluno.php"><img src="logo1.png" alt="ReservENE"></a>
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
                                                                  <li><a href="aluno.php" onclick="location.href='aluno.php'">Mapa de Salas</a></li>
                                                                  <li><a href="aluno-hist.php" onclick="location.href='aluno-hist.php'">Requisições</a></li>
                                                                  <li><a href="logout.php" onclick="location.href='logout.php'">Sair</a></li>
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

			<section id="section2" class="about">
				  <div class="container">
						<!-- Title row -->
						<div class="row">
							  <div class="col-md-12 big-title wow bounceIn">
								  <select id='location'>
							  	  <option value="">TODAS</option>
							  	  <option value="B1 01/5 LAB 1" selected="selected">Laboratório 1: Eletrônica e Princípios de Comunicação </option>
							  	  <option value="B1 01/6 LAB 2">Laboratório 2: Circuitos Elétricos e Eletrônica</option>
							  	  <option value="B1 01/7 LAB 3">Laboratório 3: Sistemas Digitais</option>
							  	  <option value="ENE AT 11">ENE AT 11</option>
							  	  <option value="ENE AT 13">ENE AT 13</option>
							  	  <option value="ENE AT 15">ENE AT 15</option>
							  	  <option value="ENE AT 17">ENE AT 17</option>
							  	  <option value="ENE AT 19">ENE AT 19</option>
							  	  <option value="CDT">CDT</option>
							  	  <option value="LCCC">LCCC</option>
							  	  <option value="LABREDES">LABREDES</option>
							  	  <option value="Laboratório de Instalações Elétricas e Eletricidade Básica">Laboratório de Instalações Elétricas e Eletricidade Básica</option>
							  	  <option value="Laboratório de Conversão de Energia">Laboratório de Conversão de Energia</option>
							  	  <option value="Laboratório de Materiais Elétricos e Magnéticos">Laboratório de Materiais Elétricos e Magnéticos</option>
							  	  <option value="Laboratório de Eletromagnetismo e Antenas">Laboratório de Eletromagnetismo e Antenas</option>
							  	  <option value="Laboratório de Controle e Automação">Laboratório de Controle e Automação</option>
							  	  <option value="Auditório BT 11/15">Auditório BT 11/15</option>
							  	  <option value="SG 11">SG 11</option>
							  	</select>
							  	<select id='class'>
							  		<option value="">TODOS</option>
							  		<option value="ALGORITMO E ESTRUTURA DE DADOS">ALGORITMO E ESTRUTURA DE DADOS</option>
							  		<option value="ANALISE DE SISTEMAS DE POTENCIA">ANALISE DE SISTEMAS DE POTENCIA</option>
							  		<option value="ANÁLISE DINÂMICA LINEAR">ANÁLISE DINÂMICA LINEAR</option>
							  		<option value="ARQUITETURA DE PROCESSADORES DIGITAIS ">ARQUITETURA DE PROCESSADORES DIGITAIS</option>
							  		<option value="ARQUITETURA E PROTOCOLOS DE REDES">ARQUITETURA E PROTOCOLOS DE REDES</option>
							  		<option value="AVALIAÇÃO DE DESEMPENHO DE REDES E SISTEMAS">AVALIAÇÃO DE DESEMPENHO DE REDES E SISTEMAS</option>
							  		<option value="CIRCUITOS ELÉTRICOS">CIRCUITOS ELÉTRICOS</option>
							  	  	<option value="CIRCUITOS ELÉTRICOS 2">CIRCUITOS ELÉTRICOS 2</option>
							  		<option value="CIRCUITOS POLIFASICOS">CIRCUITOS POLIFASICOS</option>
							  		<option value="COMPUTACAO PARA ENGENHARIA">COMPUTACAO PARA ENGENHARIA</option>
							  		<option value="COMUNICACOES DIGITAIS">COMUNICACOES DIGITAIS</option>
							  		<option value="COMUNICAÇÕES MÓVEIS">COMUNICAÇÕES MÓVEIS</option>
							  		<option value="COMUNICACOES OPTICAS">COMUNICACOES OPTICAS</option>
							  		<option value="CONTROLE DE PROCESSOS">CONTROLE DE PROCESSOS</option>
							  		<option value="CONTROLE DIGITAL">CONTROLE DIGITAL</option>
							  	  	<option value="CONTROLE DINÂMICO">CONTROLE DINÂMICO</option>
							  		<option value="CONTROLE PARA AUTOMAÇÃO">CONTROLE PARA AUTOMAÇÃO</option>
							  		<option value="CONVERSAO DE ENERGIA">CONVERSAO DE ENERGIA</option>
							  		<option value="CONVERSÃO ELETROMECÂNICA DE ENERGIA">CONVERSÃO ELETROMECÂNICA DE ENERGIA</option>
							  		<option value="DISPOSITIVOS E CIRCUITOS ELETRÔNICOS">DISPOSITIVOS E CIRCUITOS ELETRÔNICOS</option>
							  		<option value="ELETRICIDADE BÁSICA">ELETRICIDADE BÁSICA</option>
							  		<option value="ELETROMAGNETISMO 1">ELETROMAGNETISMO 1</option>
							  		<option value="ELETROMAGNETISMO 2">ELETROMAGNETISMO 2</option>
							  		<option value="ELETRÔNICA">ELETRÔNICA</option>
							  		<option value="ELETRÔNICA 2">ELETRÔNICA 2</option>
							  		<option value="FUNDAMENTOS DE REDES">FUNDAMENTOS DE REDES</option>
							  		<option value="FUNDAMENTOS DE REDES 2">FUNDAMENTOS DE REDES 2</option>
							  		<option value="GERÊNCIA DE REDES E SISTEMAS">GERÊNCIA DE REDES E SISTEMAS</option>
							  		<option value="INSTALAÇÕES ELÉTRICAS">INSTALAÇÕES ELÉTRICAS</option>
							  		<option value="INSTALAÇÕES ELETRICAS">INSTALAÇÕES ELETRICAS</option>
							  		<option value="INSTRUMENTACAO DE CONTROLE">INSTRUMENTACAO DE CONTROLE</option>
							  		<option value="INSTRUMENTAÇÃO DE CONTROLE DE PROCESSOS">INSTRUMENTAÇÃO DE CONTROLE DE PROCESSOS</option>
							  		<option value="INTRODUÇÃO A ENGENHARIA DE REDES DE COMUNICACÃO">INTRODUÇÃO A ENGENHARIA DE REDES DE COMUNICACÃO</option>
							  		<option value="INTRODUCAO A ENGENHARIA ELETRICA">INTRODUCAO A ENGENHARIA ELETRICA</option>
							  		<option value="INTRODUÇÃO AO CONTROLE INTELIGENTE NUMÉRICO">INTRODUÇÃO AO CONTROLE INTELIGENTE NUMÉRICO</option>
							  		<option value="LABORATÓRIO DE ANÁLISE DINÂMICA LINEAR">LABORATÓRIO DE ANÁLISE DINÂMICA LINEAR</option>
							  		<option value="LABORATÓRIO DE ARQUITETURA DE PROCESSADORES DIGITAIS">LABORATÓRIO DE ARQUITETURA DE PROCESSADORES DIGITAIS</option>
							  		<option value="LABORATÓRIO DE ARQUITETURA E PROTOCOLOS DE REDES">LABORATÓRIO DE ARQUITETURA E PROTOCOLOS DE REDES</option>
							  		<option value="LABORATÓRIO DE CIRCUITOS ELÉTRICO 2">LABORATÓRIO DE CIRCUITOS ELÉTRICO 2</option>
							  		<option value="LABORATÓRIO DE CIRCUITOS ELÉTRICOS">LABORATÓRIO DE CIRCUITOS ELÉTRICOS</option>
							  		<option value="LABORATÓRIO DE CONTROLE DE PROCESSOS">LABORATÓRIO DE CONTROLE DE PROCESSOS</option>
							  		<option value="LABORATÓRIO DE CONTROLE DINÂMICO">LABORATÓRIO DE CONTROLE DINÂMICO</option>
							  		<option value="LABORATORIO DE CONVERSAO DE ENERGIA">LABORATORIO DE CONVERSAO DE ENERGIA</option>
							  		<option value="LABORATÓRIO DE CONVERSÃO ELETROMECÂNICA DE ENERGIA">LABORATÓRIO DE CONVERSÃO ELETROMECÂNICA DE ENERGIA</option>
							  		<option value="LABORATÓRIO DE DISPOSITIVOS E CIRCUITOS ELETRÔNICOS">LABORATÓRIO DE DISPOSITIVOS E CIRCUITOS ELETRÔNICOS</option>
							  		<option value="LABORATÓRIO DE ELETRICIDADE BÁSICA">LABORATÓRIO DE ELETRICIDADE BÁSICA</option>
							  		<option value="LABORATÓRIO DE ELETROMAGNETISMO 2">LABORATÓRIO DE ELETROMAGNETISMO 2</option>
							  		<option value="LABORATÓRIO DE ELETRÔNICA">LABORATÓRIO DE ELETRÔNICA</option>
							  		<option value="LABORATÓRIO DE ELETRÔNICA 2">LABORATÓRIO DE ELETRÔNICA 2</option>
							  		<option value="LABORATÓRIO DE INSTALAÇÕES ELÉTRICAS">LABORATÓRIO DE INSTALAÇÕES ELÉTRICAS</option>
							  		<option value="LABORATÓRIO DE MATERIAIS ELÉTRICOS E MAGNÉTICOS">LABORATÓRIO DE MATERIAIS ELÉTRICOS E MAGNÉTICOS</option>
							  		<option value="LABORATÓRIO DE PRINCÍPIOS DE COMUNICAÇÃO">LABORATÓRIO DE PRINCÍPIOS DE COMUNICAÇÃO</option>
							  		<option value="LABORATÓRIO DE SISTEMAS DIGITAIS">LABORATÓRIO DE SISTEMAS DIGITAIS</option>
							  		<option value="LABORATÓRIO DE SISTEMAS MICROPROCESSADOS">LABORATÓRIO DE SISTEMAS MICROPROCESSADOS</option>
							  		<option value="MAQUINAS ELETRICAS">MAQUINAS ELETRICAS</option>
							  		<option value="MATERIAIS ELÉTRICOS E MAGNÉTICOS">MATERIAIS ELÉTRICOS E MAGNÉTICOS</option>
							  		<option value="METODOLOGIA E DESENVOLVIMENTO DE SOFTWARE">METODOLOGIA E DESENVOLVIMENTO DE SOFTWARE</option>
							  		<option value="PRINCÍPIOS DE COMUNICAÇÃO">PRINCÍPIOS DE COMUNICAÇÃO</option>
							  <!--		<option value="CONTROLE DE PROCESSOS">PROJETO FINAL DE GRADUAÇÃO 1</option>
							  		<option value="CONTROLE DE PROCESSOS">PROJETO FINAL DE GRADUAÇÃO 2</option> -->
							  		<option value="PROJETO TRANSVERSAL EM REDES DE COMUNICAÇÃO 1">PROJETO TRANSVERSAL EM REDES DE COMUNICAÇÃO 1</option>
							  		<option value="REDES LOCAIS">REDES LOCAIS</option>
							  		<option value="SEGURANÇA DE REDES">SEGURANÇA DE REDES</option>
							  		<option value="SINAIS E SISTEMAS EM TEMPO CONTÍNUO">SINAIS E SISTEMAS EM TEMPO CONTÍNUO</option>
							  		<option value="SISTEMAS DE COMUNICACOES 1">SISTEMAS DE COMUNICACOES 1</option>
							  		<option value="SISTEMAS DE INFORMAÇÃO DISTRIBUÍDOS">SISTEMAS DE INFORMAÇÃO DISTRIBUÍDOS</option>
							  		<option value="SISTEMAS DIGITAIS">SISTEMAS DIGITAIS</option>
							  		<option value="SISTEMAS MICROPROCESSADOS">SISTEMAS MICROPROCESSADOS</option>
							  		<option value="SISTEMAS OPERACIONAIS DE REDES">SISTEMAS OPERACIONAIS DE REDES</option>
							  		<option value="TOPICOS EM ENGENHARIA">TOPICOS EM ENGENHARIA</option>
							  		<option value="TÓPICOS EM REDES DE COMUNICAÇÃO 1">TÓPICOS EM REDES DE COMUNICAÇÃO 1</option>
							  		<option value="TÓPICOS EM REDES DE COMUNICAÇÃO 2">TÓPICOS EM REDES DE COMUNICAÇÃO 2</option>
							  		<option value="TÓPICOS ESPECIAIS EM ENGENHARIA BIOMÉDICA">TÓPICOS ESPECIAIS EM ENGENHARIA BIOMÉDICA</option>
							  		<option value="TÓPICOS ESPECIAIS EM MICROELETRÔNICA">TÓPICOS ESPECIAIS EM MICROELETRÔNICA</option>
							  <!--		<option value="CONTROLE DE PROCESSOS">TRABALHO DE CONCLUSÃO DE CURSO 1</option>
							  		<option value="CONTROLE DE PROCESSOS">TRABALHO DE CONCLUSÃO DE CURSO 2</option> -->

							  	</select>
							</div>


						  </div>
						  	<div id="calendar"></div>
						  <div class="blog-divider"></div>
						  <div class="col-md-6" >
						  	<h2>Mapa FT</h2>
						  		<img src="ft.png" alt="Mapa FT" style="width:450px;height:350px;">
						  <a href="#myModal" data-toggle="modal" data-target="#myModal" <i="" class="fa fa-info-circle"></a>
					  </div>
						  <div class="col-md-6" >
						  <h2>Mapa SG-11</h2>
						  <img src="sg11.png" alt="Mapa SG-11" style="width:450px;height:350px;">
						  <a href="#myModal1" data-toggle="modal" data-target="#myModal1" <i="" class="fa fa-info-circle"></a>
					  </div>
					  </div>
			  </section>
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
<!-- /Section 7 -->

<!-- Scroll To Top -->
<a href="#" class="scrollup"><i class="fa fa-angle-up"></i></a>
</div>
</div>
</body>
<div class="modal fade" id="myModalForm" role="dialog">
   <div class="modal-dialog modal-md" id="tamanho">

	 <!-- Modal content-->
			 <div class="modal-content">
			   <div class="modal-header">
				 <button type="button" class="close" data-dismiss="modal">&times;</button>
				 <h4 class="modal-title"></h4>
			   </div>
			   <div class="modal-body">
				<h5 class="salai" style="text-align: center; font-size: 20px;">Formulário de Requisição de Salas</h5>
				<form>
					<div class="form-group">
					  <label for="monitoria_label">Monitoria?</label><br>
					  <div class="radio">
						  <label><input type="radio" class="form-control" id="monitoria" name="monitoria" value="1">Sim</label>
					  </div>
					  <div class="radio">
						  <label><input type="radio" class="form-control" id="monitoria" name="monitoria" value="0" checked>Não</label>
					  </div>
					  <!--	  <form action="">
								  <input type="radio" id="monitoria" name="monitoria" value="1"> Sim<br>
								  <input type="radio" id="monitoria" name="monitoria" value="0"> Não<br>
						  </form> -->
					  </br>
							<div class="form-group">
							  <label>Disciplina:</br><select name="selected_class" id="selected_class">
						    <!--  <option value="">TODOS</option> -->
								  <option value="ALGORITMOS E ESTRUTURA DE DADOS">ALGORITMOS E ESTRUTURA DE DADOS</option>
								  <option value="ANALISE DE SISTEMAS DE POTENCIA">ANALISE DE SISTEMAS DE POTENCIA</option>
								  <option value="ANÁLISE DINÂMICA LINEAR">ANÁLISE DINÂMICA LINEAR</option>
								  <option value="ARQUITETURA DE PROCESSADORES DIGITAIS ">ARQUITETURA DE PROCESSADORES DIGITAIS</option>
								  <option value="ARQUITETURA E PROTOCOLOS DE REDES">ARQUITETURA E PROTOCOLOS DE REDES</option>
								  <option value="AVALIAÇÃO DE DESEMPENHO DE REDES E SISTEMAS">AVALIAÇÃO DE DESEMPENHO DE REDES E SISTEMAS</option>
								  <option value="CIRCUITOS ELÉTRICOS">CIRCUITOS ELÉTRICOS</option>
								  <option value="CIRCUITOS ELÉTRICOS 2">CIRCUITOS ELÉTRICOS 2</option>
								  <option value="CIRCUITOS POLIFASICOS">CIRCUITOS POLIFASICOS</option>
								  <option value="COMPUTACAO PARA ENGENHARIA">COMPUTACAO PARA ENGENHARIA</option>
								  <option value="COMUNICACOES DIGITAIS">COMUNICACOES DIGITAIS</option>
								  <option value="COMUNICAÇÕES MÓVEIS">COMUNICAÇÕES MÓVEIS</option>
								  <option value="COMUNICACOES OPTICAS">COMUNICACOES OPTICAS</option>
								  <option value="CONTROLE DE PROCESSOS">CONTROLE DE PROCESSOS</option>
								  <option value="CONTROLE DIGITAL">CONTROLE DIGITAL</option>
								  <option value="CONTROLE DINÂMICO">CONTROLE DINÂMICO</option>
								  <option value="CONTROLE PARA AUTOMAÇÃO">CONTROLE PARA AUTOMAÇÃO</option>
								  <option value="CONVERSAO DE ENERGIA">CONVERSAO DE ENERGIA</option>
								  <option value="CONVERSÃO ELETROMECÂNICA DE ENERGIA">CONVERSÃO ELETROMECÂNICA DE ENERGIA</option>
								  <option value="DISPOSITIVOS E CIRCUITOS ELETRÔNICOS">DISPOSITIVOS E CIRCUITOS ELETRÔNICOS</option>
								  <option value="ELETRICIDADE BÁSICA">ELETRICIDADE BÁSICA</option>
								  <option value="ELETROMAGNETISMO 1">ELETROMAGNETISMO 1</option>
								  <option value="ELETROMAGNETISMO 2">ELETROMAGNETISMO 2</option>
								  <option value="ELETRÔNICA">ELETRÔNICA</option>
								  <option value="ELETRÔNICA 2">ELETRÔNICA 2</option>
								  <option value="FUNDAMENTOS DE REDES">FUNDAMENTOS DE REDES</option>
								  <option value="FUNDAMENTOS DE REDES 2">FUNDAMENTOS DE REDES 2</option>
								  <option value="GERÊNCIA DE REDES E SISTEMAS">GERÊNCIA DE REDES E SISTEMAS</option>
								  <option value="INSTALAÇÕES ELÉTRICAS">INSTALAÇÕES ELÉTRICAS</option>
								  <option value="INSTALAÇÕES ELETRICAS">INSTALAÇÕES ELETRICAS</option>
								  <option value="INSTRUMENTACAO DE CONTROLE">INSTRUMENTACAO DE CONTROLE</option>
								  <option value="INSTRUMENTAÇÃO DE CONTROLE DE PROCESSOS">INSTRUMENTAÇÃO DE CONTROLE DE PROCESSOS</option>
								  <option value="INTRODUÇÃO A ENGENHARIA DE REDES DE COMUNICACÃO">INTRODUÇÃO A ENGENHARIA DE REDES DE COMUNICACÃO</option>
								  <option value="INTRODUCAO A ENGENHARIA ELETRICA">INTRODUCAO A ENGENHARIA ELETRICA</option>
								  <option value="INTRODUÇÃO AO CONTROLE INTELIGENTE NUMÉRICO">INTRODUÇÃO AO CONTROLE INTELIGENTE NUMÉRICO</option>
								  <option value="LABORATÓRIO DE ANÁLISE DINÂMICA LINEAR">LABORATÓRIO DE ANÁLISE DINÂMICA LINEAR</option>
								  <option value="LABORATÓRIO DE ARQUITETURA DE PROCESSADORES DIGITAIS">LABORATÓRIO DE ARQUITETURA DE PROCESSADORES DIGITAIS</option>
								  <option value="LABORATÓRIO DE ARQUITETURA E PROTOCOLOS DE REDES">LABORATÓRIO DE ARQUITETURA E PROTOCOLOS DE REDES</option>
								  <option value="LABORATÓRIO DE CIRCUITOS ELÉTRICO 2">LABORATÓRIO DE CIRCUITOS ELÉTRICO 2</option>
								  <option value="LABORATÓRIO DE CIRCUITOS ELÉTRICOS">LABORATÓRIO DE CIRCUITOS ELÉTRICOS</option>
								  <option value="LABORATÓRIO DE CONTROLE DE PROCESSOS">LABORATÓRIO DE CONTROLE DE PROCESSOS</option>
								  <option value="LABORATÓRIO DE CONTROLE DINÂMICO">LABORATÓRIO DE CONTROLE DINÂMICO</option>
								  <option value="LABORATORIO DE CONVERSAO DE ENERGIA">LABORATORIO DE CONVERSAO DE ENERGIA</option>
								  <option value="LABORATÓRIO DE CONVERSÃO ELETROMECÂNICA DE ENERGIA">LABORATÓRIO DE CONVERSÃO ELETROMECÂNICA DE ENERGIA</option>
								  <option value="LABORATÓRIO DE DISPOSITIVOS E CIRCUITOS ELETRÔNICOS">LABORATÓRIO DE DISPOSITIVOS E CIRCUITOS ELETRÔNICOS</option>
								  <option value="LABORATÓRIO DE ELETRICIDADE BÁSICA">LABORATÓRIO DE ELETRICIDADE BÁSICA</option>
								  <option value="LABORATÓRIO DE ELETROMAGNETISMO 2">LABORATÓRIO DE ELETROMAGNETISMO 2</option>
								  <option value="LABORATÓRIO DE ELETRÔNICA">LABORATÓRIO DE ELETRÔNICA</option>
								  <option value="LABORATÓRIO DE ELETRÔNICA 2">LABORATÓRIO DE ELETRÔNICA 2</option>
								  <option value="LABORATÓRIO DE INSTALAÇÕES ELÉTRICAS">LABORATÓRIO DE INSTALAÇÕES ELÉTRICAS</option>
								  <option value="LABORATÓRIO DE MATERIAIS ELÉTRICOS E MAGNÉTICOS">LABORATÓRIO DE MATERIAIS ELÉTRICOS E MAGNÉTICOS</option>
								  <option value="LABORATÓRIO DE PRINCÍPIOS DE COMUNICAÇÃO">LABORATÓRIO DE PRINCÍPIOS DE COMUNICAÇÃO</option>
								  <option value="LABORATÓRIO DE SISTEMAS DIGITAIS">LABORATÓRIO DE SISTEMAS DIGITAIS</option>
								  <option value="LABORATÓRIO DE SISTEMAS MICROPROCESSADOS">LABORATÓRIO DE SISTEMAS MICROPROCESSADOS</option>
								  <option value="MAQUINAS ELETRICAS">MAQUINAS ELETRICAS</option>
								  <option value="MATERIAIS ELÉTRICOS E MAGNÉTICOS">MATERIAIS ELÉTRICOS E MAGNÉTICOS</option>
								  <option value="METODOLOGIA E DESENVOLVIMENTO DE SOFTWARE">METODOLOGIA E DESENVOLVIMENTO DE SOFTWARE</option>
								  <option value="PRINCÍPIOS DE COMUNICAÇÃO">PRINCÍPIOS DE COMUNICAÇÃO</option>
							<!--		<option value="CONTROLE DE PROCESSOS">PROJETO FINAL DE GRADUAÇÃO 1</option>
								  <option value="CONTROLE DE PROCESSOS">PROJETO FINAL DE GRADUAÇÃO 2</option> -->
								  <option value="PROJETO TRANSVERSAL EM REDES DE COMUNICAÇÃO 1">PROJETO TRANSVERSAL EM REDES DE COMUNICAÇÃO 1</option>
								  <option value="REDES LOCAIS">REDES LOCAIS</option>
								  <option value="SEGURANÇA DE REDES">SEGURANÇA DE REDES</option>
								  <option value="SINAIS E SISTEMAS EM TEMPO CONTÍNUO">SINAIS E SISTEMAS EM TEMPO CONTÍNUO</option>
								  <option value="SISTEMAS DE COMUNICACOES 1">SISTEMAS DE COMUNICACOES 1</option>
								  <option value="SISTEMAS DE INFORMAÇÃO DISTRIBUÍDOS">SISTEMAS DE INFORMAÇÃO DISTRIBUÍDOS</option>
								  <option value="SISTEMAS DIGITAIS">SISTEMAS DIGITAIS</option>
								  <option value="SISTEMAS MICROPROCESSADOS">SISTEMAS MICROPROCESSADOS</option>
								  <option value="SISTEMAS OPERACIONAIS DE REDES">SISTEMAS OPERACIONAIS DE REDES</option>
								  <option value="TOPICOS EM ENGENHARIA">TOPICOS EM ENGENHARIA</option>
								  <option value="TÓPICOS EM REDES DE COMUNICAÇÃO 1">TÓPICOS EM REDES DE COMUNICAÇÃO 1</option>
								  <option value="TÓPICOS EM REDES DE COMUNICAÇÃO 2">TÓPICOS EM REDES DE COMUNICAÇÃO 2</option>
								  <option value="TÓPICOS ESPECIAIS EM ENGENHARIA BIOMÉDICA">TÓPICOS ESPECIAIS EM ENGENHARIA BIOMÉDICA</option>
								  <option value="TÓPICOS ESPECIAIS EM MICROELETRÔNICA">TÓPICOS ESPECIAIS EM MICROELETRÔNICA</option>
							<!--		<option value="CONTROLE DE PROCESSOS">TRABALHO DE CONCLUSÃO DE CURSO 1</option>
								  <option value="CONTROLE DE PROCESSOS">TRABALHO DE CONCLUSÃO DE CURSO 2</option> -->

							  </select></label>
						  </div>
					<div class="form-group">
					  <label for="pwd">Descrição:</label>
					  <textarea type="comment" class="form-control" id="description" rows="3"></textarea>
					</div>
					<button id="btnSubmitModal" type="button" class="btn btn-default">Enviar</button>
				</form>
			   </div>
			   <div class="modal-footer">
				 <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			   </div>
			 </div>

		   </div>
		 </div>

<div class="modal fade" id="myModal1" role="dialog">
   <div class="modal-dialog modal-md" id="tamanho">

	 <!-- Modal content-->
			 <div class="modal-content">
			   <div class="modal-header">
				 <button type="button" class="close" data-dismiss="modal">&times;</button>
				 <h4 class="modal-title">Detalhes</h4>
			   </div>
			   <div class="modal-body">
				<h5 class="salai" style="text-align: center; font-size: 20px;">Ferramentas das Salas e Auditórios:</h5>
				 <table style="width:100%; padding: 10px 0px;">
					 <tr>
					   <th>Laboratórios do SG-11</th>
					   <th>Auditório do SG-11</th>

					 </tr>
					 <tr>
					   <td>Até 45 pessoas</td>
					   <td>Até 50 pessoas</td>

					 </tr>
					 <tr>
					   <td>Até 25 computadores</td>
					   <td>Nenhum computador</td>

					 </tr>
					 <tr>
					   <td>1 quadro branco</td>
					   <td>1 quadro-de-giz</td>

					 </tr>
					 <tr>
					   <td>1 projetor</td>
					   <td>1 projetor</td>
					 </tr>
					 <tr>
					   <td>2 ar-condicionados</td>
					   <td>2 ar-condicionados</td>

					 </tr>
				   </table>
			   </div>
			   <div class="modal-footer">
				 <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			   </div>
			 </div>

		   </div>
		 </div>


<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog modal-lg" id="tamanho">

	  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Detalhes</h4>
				</div>
				<div class="modal-body">
				 <h5 class="salai" style="text-align: center; font-size: 20px;">Ferramentas das Salas e Auditórios:</h5>
				  <table style="width:100%; padding: 10px 0px;">
					  <tr>
						<th>AT-11</th>
						<th>AT-13</th>
						<th>AT-15</th>
						<th>AT-19</th>
						<th>Auditório ENE</th>
						<th>Lab-Redes</th>
						<th>LCCC</th>

					  </tr>
					  <tr>
						<td>Até 50 pessoas</td>
						<td>Até 50 pessoas</td>
						<td>Até 50 pessoas</td>
						<td>Até 50 pessoas</td>
						<td>Até 120 pessoas</td>
						<td>Até 40 pessoas</td>
						<td>Até 40 pessoas</td>

					  </tr>
					  <tr>
						<td>Nenhum computador</td>
						<td>Nenhum computador</td>
						<td>Nenhum computador</td>
						<td>Nenhum computador</td>
						<td>Nenhum computador</td>
						<td>Até 40 computadores</td>
						<td>Até 40 computadores</td>

					  </tr>
					  <tr>
						<td>1 quadro-de-giz</td>
						<td>1 quadro-de-giz</td>
						<td>1 quadro-de-giz</td>
						<td>1 quadro-de-giz</td>
						<td>1 quadro-de-giz</td>
						<td>1 quadro branco</td>
						<td>1 quadro branco</td>

					  </tr>
					  <tr>
						<td>1 projetor</td>
						<td>1 projetor</td>
						<td>1 projetor</td>
						<td>1 projetor</td>
						<td>1 projetor</td>
						<td>2 projetores</td>
						<td>1 projetor</td>

					  </tr>
					  <tr>
						<td>2 ar-condicionados</td>
						<td>2 ar-condicionados</td>
						<td>2 ar-condicionados</td>
						<td>2 ar-condicionados</td>
						<td>5 ar-condicionados</td>
						<td>2 ar-condicionados</td>
						<td>2 ar-condicionados</td>

					  </tr>
					</table>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				</div>
			  </div>

			</div>
		  </div>
</html>
