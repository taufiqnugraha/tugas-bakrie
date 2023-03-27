<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>PT. Bakrie Pipe Industries</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Bakrie Pipe Industries" name="description" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url() . 'assets/images/favicon.ico'; ?>">
    <!-- Select 2 -->
    <link href="<?php echo base_url() ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Css -->
    <link href="<?php echo base_url() . 'assets/css/bootstrap.min.css'; ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo base_url() . 'assets/css/icons.min.css'; ?>" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo base_url() . 'assets/css/app.min.css'; ?>" id="app-style" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() . 'assets/css/custom.css?time=' . time(); ?>" rel="stylesheet" type="text/css" />
    <!-- Sweet Alert-->
    <link href="<?php echo base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- Date Picker -->
    <link href="<?php echo base_url() ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <!-- Loader -->
    <link href="<?php echo base_url() ?>assets/css/overlay-loading.css" rel="stylesheet">
</head>

<body data-topbar="dark" data-layout="horizontal">
    <!-- Loader -->
    <div class="loading d-none"></div>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="<?php echo base_url(); ?>" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="<?php echo base_url() . 'assets/images/logo.png'; ?>" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="<?php echo base_url() . 'assets/images/logo.png'; ?>" alt="" height="35">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                </div>

                <div class="d-flex">
                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="bx bx-fullscreen"></i>
                        </button>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="<?php echo base_url() . 'assets/images/logo.png'; ?>" alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ms-1" key="t-henry"><?php echo $_SESSION['fullname']; ?></span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="<?php echo base_url() . 'logout'; ?>"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="topnav">
            <div class="container-fluid">
                <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav">
                            <?php $menu = get_accessmenu();
                            foreach ($menu as $ls) :
                                $submenu = get_submenu($ls['menu_id']);

                                if($ls['link'] == ''){
                                    $link = '#';
                                } else {
                                    if($ls['link'] != NULL){
                                        $link = base_url() . $ls['link'];
                                    } else {
                                        $link = $ls['link'];
                                    }
                                }
                            ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="<?php echo $link; ?>" id="<?php echo $ls['nav_id'] ?>" role="button">
                                        <i class="bx <?php echo $ls['icon'] ?> me-2"></i><span key="<?php echo $ls['span_key'] ?>"><?php echo $ls['menu_name'] ?></span>
                                        <?php if (count($submenu) > 0) : echo '<div class="arrow-down"></div>';
                                        endif ?>
                                    </a>
                                    <?php if (count($submenu) > 0) : ?>
                                        <div class="dropdown-menu" aria-labelledby="topnav-master">
                                            <?php foreach ($submenu as $list) : ?>
                                                <a href="<?php echo base_url() . $list['link'] ?>" class="dropdown-item" key="t-tarif"><?php echo $list['submenu_name'] ?></a>
                                            <?php endforeach ?>
                                        </div>
                                    <?php endif ?>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <?php echo $contents; ?>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="text-sm-start d-none d-sm-block">
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> © Bakrie Pipe Industries
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- Hostname -->
    <script>
        var hostname = '<?php echo base_url(); ?>';
    </script>

    <!-- JAVASCRIPT -->
    <script src="<?php echo base_url() . 'assets/libs/jquery/jquery.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'assets/libs/bootstrap/js/bootstrap.bundle.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'assets/libs/metismenu/metisMenu.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'assets/libs/simplebar/simplebar.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'assets/libs/node-waves/waves.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'assets/js/pages/js-validate.min.js'; ?>"></script>


    <!-- Sweet Alerts js -->
    <script src="<?php echo base_url() ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <!-- Chart JS -->
    <script src="<?php echo base_url() ?>assets/libs/chart.js/Chart.bundle.min.js"></script>
    <!-- DATA TABLE -->
    <script src="<?php echo base_url() ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Date Picker-->
    <script src="<?php echo base_url() ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/select2/js/select2.min.js"></script>

    <script src="<?php echo base_url() . 'assets/js/main.js?time=' . time(); ?>"></script>

    <!-- apexcharts -->
    <!--<script src="<?php echo base_url() . 'assets/libs/apexcharts/apexcharts.min.js'; ?>"></script> -->

    <?php if (isset($javascript) && $javascript != '') { ?>
        <script src="<?php echo base_url() . 'assets/js/' . $javascript; ?>?time=<?php echo time(); ?>"></script>
    <?php } ?>

    <script src="<?php echo base_url() . 'assets/js/app.js'; ?>"></script>
</body>

</html>
