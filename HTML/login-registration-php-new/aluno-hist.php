
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
	if($row['userType'] != 0)
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
	<!-- Skin -->
	<link rel="stylesheet" href="css/colors/blue.css" class="colors">
    <!-- DataTables CSS -->
    <link href="css/dataTables.bootstrap.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <!-- <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet" -->
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
                                                                  <li><a href="aluno-hist.php" onclick="location.href='aluno-hist.php'">Minhas Requisições</a></li>
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
			                <div class="col-lg-12">
			                    <h1 class="page-header">Minhas Requisições</h1>
			                </div>
			                <!-- /.col-lg-12 -->
			            </div>
						<div class="row">

						  <div class="col-md-12 big-title wow bounceIn">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
										<th>#</th>
										<th>Aceito?</th>
                                        <th>Sala</th>
                                        <th>Horário</th>
										<th>Monitoria?</th>
                                        <th>Detalhes</th>
                                    </tr>
                                </thead>

                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
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
    </body>

    <script src="js/jquery.min.js"></script>
    <script src='js/lib/moment.min.js'></script>
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
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/dataTables.responsive.js"></script>



    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>var oTable;


    $(document).ready(function() {

        oTable = $('#dataTables-example').DataTable({
			"ajax": "get_selfreservas.php",
			'columnDefs': [{
				'targets': 0,
				'searchable': false,
				'orderable': false,
				'className': 'dt-body-center',
				'render': function (data, type, row, meta){
					if(row[1] == -1)
					{
						return '<i class="fa fa-check" aria-hidden="true"></i><i class="fa fa-ban" aria-hidden="true"></i>';

					}
					else if(row[1] == 0)
					{
						return '<i class="fa fa-check" aria-hidden="true"></i><i class="fa fa-ban" aria-hidden="true" style="color:red"></i>';
					}
					else if(row[1] == 1)
					{
						return '<i class="fa fa-check" aria-hidden="true" style="color:green"></i><i class="fa fa-ban" aria-hidden="true"></i>';
					}
				}
			},
			{
				"targets": [1],
				"visible": false
			},
			{
				"targets": [3],
				"orderable": false
			},
			],
            "responsive": true,
            "language": {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ resultados por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            },
        });
    });
    </script>

</body>

</html>
