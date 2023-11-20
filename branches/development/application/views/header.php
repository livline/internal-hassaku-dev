<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/assets/images/favicon.ico" type="image/x-icon">
    <title><?= SITE_TITLE; ?></title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700&amp;display=swap" rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="/assets/css/fontawesome.css?<?= time(); ?>">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="/assets/css/icofont.css?<?= time(); ?>">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="/assets/css/themify.css?<?= time(); ?>">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="/assets/css/flag-icon.css?<?= time(); ?>">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="/assets/css/feather-icon.css?<?= time(); ?>">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="/assets/css/ionic-icon.css?<?= time(); ?>">
    <link rel="stylesheet" type="text/css" href="/assets/css/chartist.css?<?= time(); ?>">
    <link rel="stylesheet" type="text/css" href="/assets/css/prism.css?<?= time(); ?>">
    <link rel="stylesheet" type="text/css" href="/assets/css/date-picker.css?<?= time(); ?>">
    <link rel="stylesheet" type="text/css" href="/assets/css/datatables.css?<?= time(); ?>">
    <link rel="stylesheet" type="text/css" href="/assets/css/timepicker.css?<?= time(); ?>">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.css?<?= time(); ?>">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css?<?= time(); ?>">
    <link id="color" rel="stylesheet" href="/assets/css/color-1.css?<?= time(); ?>" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="/assets/css/responsive.css?<?= time(); ?>">
    <!-- hassaku css-->
    <link rel="stylesheet" type="text/css" href="/assets/css/hassaku.css?<?= time(); ?>">
    <!-- latest jquery-->
    <script src="/assets/js/jquery-3.5.1.min.js?<?= time(); ?>"></script>    	

  </head>
  <body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
      <div class="theme-loader"></div>
    </div>
    <!-- Loader ends-->
    
    
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <!-- Page Header Start-->
      <div class="page-main-header">
        <div class="main-header-right">
          <div class="main-header-left">
            <div class="logo-wrapper"><a href="/dashboard"><img src="/assets/images/logo/logo.png" alt="" width="50px"></a></div>
          </div>
          <div class="mobile-sidebar">
            <div class="flex-grow-1 text-end switch-sm">
              <label class="switch">
                <input id="sidebar-toggle" type="checkbox" data-bs-toggle=".container" checked="checked"><span class="switch-state"></span>
              </label>
            </div>
          </div>
        <!-- ログイン名表示 start -->
          <div class="nav-right col pull-right right-menu">
            <ul class="nav-menus">
              <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
              <li class="onhover-dropdown px-0"><span class="d-flex user-header"><img class="me-2 rounded-circle img-35" src="/assets/images/common/user.png" alt=""><span class="flex-grow-1"><span class="f-12 f-w-600"><?= $_SESSION[ 'user_name' ] ?></span><span class="d-block"><?= $_SESSION[ 'department_name' ] ?></span></span></span>
                <ul class="profile-dropdown onhover-show-div">
                  <li><a href="/auth/logout"><i data-feather="log-out"> </i>ログアウト</a></li>
                </ul>
              </li>
            </ul>
          </div>
        <!-- ログイン名表示 end -->
          <div class="d-lg-none mobile-toggle pull-right"><i data-feather="more-horizontal"></i></div>
        </div>
      </div>
      <!-- Page Header Ends -->
      
      <!-- Page Body Start-->
      <div class="page-body-wrapper sidebar-icon">
        <nav-menus></nav-menus>
        <header class="main-nav">
          <nav>
            <div class="main-navbar">
              <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
              <div id="mainnav">
                <ul class="nav-menu custom-scrollbar">
                  <li class="back-btn">
                    <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                  </li>
                  <li class="dropdown"><a class="nav-link menu-title link-nav" href="/dashboard"><i data-feather="home"></i><span>ダッシュボード</span></a></li>
                  <li class="dropdown"><a class="nav-link menu-title" href="#"><i data-feather="calendar"></i><span>総合管理メニュー</span></a>
                    <ul class="nav-submenu menu-content">
                      <li><a class="submenu-title" href="#">公共ます工事<span class="sub-arrow"><i class="fa fa-chevron-right"></i></span></a>
                        <ul class="nav-sub-childmenu submenu-content">
                          <li><a href="#">新規登録</a></li>
                          <li><a href="#">配分計算</a></li>
                        </ul>
                      </li>
                      <li><a class="submenu-title" href="#">維持補修工事<span class="sub-arrow"><i class="fa fa-chevron-right"></i></span></a>
                        <ul class="nav-sub-childmenu submenu-content">
                          <li><a href="#">新規登録</a></li>
                          <li><a href="#">配分計算</a></li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown"><a class="nav-link menu-title" href="#"><i data-feather="calendar"></i><span>MASメニュー</span></a>
                    <ul class="nav-submenu menu-content">
                      <li><a class="submenu-title" href="#">工事検索<span class="sub-arrow"><i class="fa fa-chevron-right"></i></span></a>
                        <ul class="nav-sub-childmenu submenu-content">
                          <li><a href="#">工事状況管理</a></li>
                          <li><a href="#">工事状況集計</a></li>
                        </ul>
                      </li>
                      <li><a class="submenu-title" href="#">組合員メニュー<span class="sub-arrow"><i class="fa fa-chevron-right"></i></span></a>
                        <ul class="nav-sub-childmenu submenu-content">
                          <li><a href="#">予定登録</a></li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown"><a class="nav-link menu-title" href="#"><i data-feather="calendar"></i><span>施工体制メニュー</span></a>
                    <ul class="nav-submenu menu-content">
                      <li><a class="submenu-title" href="#">共同受注<span class="sub-arrow"><i class="fa fa-chevron-right"></i></span></a>
                        <ul class="nav-sub-childmenu submenu-content">
                          <li><a href="/constructionsystem/application">申請</a></li>
                          <li><a href="/constructionsystem/worktype">希望工種</a></li>
                          <li><a href="/constructionsystem/status">施工体制入力状況確認</a></li>
                        </ul>
                      </li>
                      <li><a class="submenu-title" href="#">施工体制登録<span class="sub-arrow"><i class="fa fa-chevron-right"></i></span></a>
                        <ul class="nav-sub-childmenu submenu-content">
                          <li><a href="/constructionsystem/company">自社</a></li>
                          <li><a href="/constructionsystem/waste">一般・産業廃棄物許可</a></li>
          				  <li><a href="/constructionsystem/vehicle">車両・資機材</a></li>
          				  <li><a href="/constructionsystem/employee">社員</a></li>
                          <li><a href="/constructionsystem/contractor">専属下請</a></li>
          				  <li><a href="/constructionsystem/subworker">専属下請作業員</a></li>
          				  <li><a href="/constructionsystem/maintedisposalplan">処分計画（維補）</a></li>
          				  <li><a href="/constructionsystem/masdisposalplan">処分計画（公ます）</a></li>
          				  <li><a href="/constructionsystem/transport">運搬車両届</a></li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                  <!-- li class="dropdown"><a class="nav-link menu-title" href="#"><i data-feather="globe"></i><span>マスタ管理</span></a>
                    <ul class="nav-submenu menu-content">
                      <li><a class="submenu-title" href="#">自社<span class="sub-arrow"><i class="fa fa-chevron-right"></i></span></a>
                        <ul class="nav-sub-childmenu submenu-content">
	                      <li><a href="typography.html">自社マスタ</a></li>
	                      <li><a href="avatars.html">自社部門マスタ</a></li>
	                      <li><a href="helper-classes.html">自社部門所属マスタ</a></li>
                        </ul>
                      </li>
                      <li><a class="submenu-title" href="#">従業員<span class="sub-arrow"><i class="fa fa-chevron-right"></i></span></a>
                        <ul class="nav-sub-childmenu submenu-content">
                          <li><a href="tab-bootstrap.html">従業員マスタ</a></li>
                          <li><a href="tab-material.html">アカウントマスタ</a></li>
                        </ul>
                      </li>
                    </ul>
                  </li -->
                </ul>
              </div>
              <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </div>
          </nav>
        </header>
        <!-- Page Sidebar Ends-->