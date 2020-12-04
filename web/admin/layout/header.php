<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- Favicon icon -->
	<link rel="shortcut icon" type="image/x-icon" href="/assets/img/ico.png" />
	<title>WINNERS</title>
    
    <!-- This page CSS -->
    <link href="<?=$skin_dir?>/assets/css/style.min.css?<?=nowdate()?>" rel="stylesheet">
    <!-- This page CSS -->
    <link href="<?=$skin_dir?>/assets/node_modules/datatables/media/css/dataTables.bootstrap4.css?<?=nowdate()?>" rel="stylesheet">
    <link href="<?=$skin_dir?>/assets/node_modules/morrisjs/morris.css?<?=nowdate()?>" rel="stylesheet">
    <link href="<?=$skin_dir?>/assets/node_modules/c3-master/c3.min.css?<?=nowdate()?>" rel="stylesheet">

    <link href="<?=$skin_dir?>/assets/dist/css/pages/dashboard1.css?<?=nowdate()?>" rel="stylesheet">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="skin-default fixed-layout">

    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== 
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">대시보드</p>
        </div>
    </div>
    -->
    
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="/admin">
                        <!-- Logo icon --><b>
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <img src="<?=$skin_dir?>/assets/img/logo-icon.png" alt="homepage" class="dark-logo" style="width:50px;height:50px;"/>
                        <!-- Light Logo icon -->
                        <img src="<?=$skin_dir?>/assets/img/logo-light-icon.png" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
												<!-- Logo text -->
												<!-- <span> -->
                         <!-- dark Logo text -->
                         <!-- <img src="<?=$skin_dir?>/assets/img/logo-text.png" alt="homepage" class="dark-logo" style="width:50px;height:50px;"/> -->
                         <!-- Light Logo text -->    
												 <!-- <img src="<?=$skin_dir?>/assets/img/logo-light-text.png" class="light-logo" alt="homepage" /> -->
												<!-- </span> -->
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)">
	                        <i class="icon-menu"></i></a> </li>
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        <li style="color: white;"><?=@$mb->member_id?></li>
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item right-side-toggle"> <a class="nav-link  waves-effect waves-light" href="javascript:void(0)"><i class="fas fa-compass"></i></a></li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        
        <!-- ============================================================== -->
        <?include "/var/www/html/winners/www/views/web/admin/layout/sidebar.php";?>
        <!-- ============================================================== -->
        