<?php
require_once "auth.php";?>
		<?php echo $client;?></title>
<!-- Bootstrap core CSS -->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap/css/style.css" rel="stylesheet">
        <link href="bootstrap/css/font-awesome.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="jumbotron.css" rel="stylesheet">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="js/ga.js" async="" type="text/javascript"></script>
	
	<script>

     var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-23019901-1']);
      _gaq.push(['_setDomainName', "bootswatch.com"]);
        _gaq.push(['_setAllowLinker', true]);
      _gaq.push(['_trackPageview']);

     (function() {
       var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
       ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
       var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
     })();

    </script>
	 </head>
 <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-main" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
					<a href="index.php" class="navbar-brand"><img src="img/logo.jpg" height="30"></a>
				</div>
<?php	if (!empty($_SESSION['depot_mgr_name'])){
			echo'
			<div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav">
           
          </ul>
		  <ul class="nav navbar-nav navbar-right">
			 <li><a href="depotmgr.php"><strong>'.$_SESSION['depot_mgr_name'].'</strong></a></li>
            <li><a href="logoutdepotmgr.php">Logout</a></li>
            <li><a href="" ></a></li>
          </ul>

        </div>
                <!--/.navbar-collapse -->
            </div>
        </nav>
	';}
	else if (!empty($_SESSION['adm_name'])){
			echo'
              <div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav">

          </ul>
		  <ul class="nav navbar-nav navbar-right">
		              <li><a href="admin.php"><strong>'.$_SESSION['adm_name'].'</strong></a></li>
            <li><a href="logoutadmin.php" >Logout</a></li>
            <li><a href="" ></a></li>
          </ul>

        </div>
                <!--/.navbar-collapse -->
            </div>
        </nav>
	';}
	else {
		echo ' <div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav">
           
          </ul>
		  <ul class="nav navbar-nav navbar-right">
            <li><a href="" ></a></li>
            <li><a href="" ></a></li>
          </ul>

        </div>
                <!--/.navbar-collapse -->
            </div>
        </nav>';}
		
?>
   


