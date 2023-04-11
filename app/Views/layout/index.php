<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TMS | LogiCrew</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- sweetalert -->
    <script src="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/daterangepicker/daterangepicker.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= site_url() ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= site_url() ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= site_url() ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>

    <style>
        a {
            text-decoration: none;
        }
    </style>

<body class="hold-transition sidebar-mini" onload="update_resi()">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto ">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Messages Dropdown Menu -->
                <div class="user-panel d-flex flex-row bd-highlight pr-lg-3 justify-content-center align-items-center">
                    <div class="image pr-3 ">
                        <img src="<?= base_url() ?>/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <li class="user-panel pr-3">
                        <p class="m-0 text-bold"><?= user()->username ?></p>
                    </li>
                    <li class="user-panel pr-3">
                        <a href="<?= base_url("/logout") ?>" class="btn btn-sm btn-danger"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
                    </li>
                </div>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= base_url() ?>/index3.html" class="brand-link">
                <img src="<?= base_url() ?>/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Logistic Crew</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-4">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                        <li class="nav-item">
                            <a href="<?= site_url('Home/index') ?>" class="nav-link <?= $menu == 'dashboard' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-laptop"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('CStatus/index') ?>" class="nav-link <?= $menu == 'status' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-th-large"></i>
                                <p>
                                    Status
                                </p>
                            </a>
                        </li>

                        <li class="nav-header">Customer</li>
                        <li class="nav-item">
                            <a href="<?= site_url('CSellerList/index') ?>" class="nav-link <?= $menu == 'seller' ? 'active' : '' ?>">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    List Seller
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('CWarehouseList/index') ?>" class="nav-link <?= $menu == 'warehouse' ? 'active' : '' ?>">
                                <i class="nav-icon fa fa-warehouse"></i>
                                <p>
                                    List Warehouse
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('CListAgen/index') ?>" class="nav-link <?= $menu == 'agen' ? 'active' : '' ?>">
                                <i class="nav-icon fa fa-briefcase"></i>
                                <p>
                                    List Agen
                                </p>
                            </a>
                        </li>


                        <li class="nav-header">Team HUB</li>
                        <li class="nav-item">
                            <a href="<?= site_url('CInbound/index') ?>" class="nav-link <?= $menu == 'inbound' ? 'active' : '' ?>">
                                <i class="nav-icon fa fa-box"></i>
                                <p>
                                    Inbound
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('CSorting/index') ?>" class="nav-link <?= $menu == 'sorting' ? 'active' : '' ?>">
                                <i class="nav-icon fa fa-cubes"></i>
                                <p>
                                    Sorting
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('COutbound/index') ?>" class="nav-link <?= $menu == 'outbound' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-truck"></i>
                                <p>
                                    Outbound
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('CReturn/index') ?>" class="nav-link <?= $menu == 'return' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-undo"></i>
                                <p>
                                    Return
                                </p>
                            </a>
                        </li>

                        <li class="nav-header">Report</li>
                        <li class="nav-item">
                            <a href="<?= site_url('CReport/index') ?>" class="nav-link <?= $menu == 'report' ? 'active' : '' ?>">
                                <i class="nav-icon fa fa-file-alt"></i>
                                <p>
                                    Report
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('CAnalytics/index') ?>" class="nav-link <?= $menu == 'analytics' ? 'active' : '' ?>">
                                <i class="nav-icon fa fa-chart-line"></i>
                                <p>
                                    Analytics
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('CUsers/index') ?>" class="nav-link <?= $menu == 'users' ? 'active' : '' ?>">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    Manage Users
                                </p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <?= $this->renderSection('judul') ?>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= site_url($link) ?>"><?= $menu ?></a></li>
                                <li class="breadcrumb-item active"><?= $submenu ?></li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <?= $this->renderSection('subjudul') ?>
                    <?= $this->renderSection('isi') ?>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://tomy21.github.io/portfolio/">Tomy Agung Saputro</a>.</strong> All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>/dist/js/adminlte.min.js"></script>
    <!-- Select2 -->
    <script src="<?= base_url() ?>/plugins/select2/js/select2.full.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- date-range-picker -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- DataTables  & Plugins -->
    <script src="<?= site_url() ?>/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= site_url() ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= site_url() ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= site_url() ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= site_url() ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= site_url() ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= site_url() ?>/plugins/jszip/jszip.min.js"></script>
    <script src="<?= site_url() ?>/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?= site_url() ?>/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?= site_url() ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= site_url() ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?= site_url() ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="<?= base_url() ?>/plugins/select2/js/select2.full.min.js"></script>
    <script>
        function play_notif() {
            var audio = document.createElement('audio');
            audio.setAttribute('src', '<?= base_url() ?>/dist/ringtone/success.mp3');
            audio.setAttribute('autoplay', 'autoplay');
            audio.play();
            audio.load();
        }

        function play_notifSalah() {
            var audio = document.createElement('audio');
            audio.setAttribute('src', '<?= base_url() ?>/dist/ringtone/Salah2.mp3');
            audio.setAttribute('autoplay', 'autoplay');
            audio.play();
            audio.load();
        }

        function update_resi() {
            $.ajax({
                url: "<?php echo site_url('CStatus/update_resi') ?>",
                success: function(html) {

                }
            });
        }
    </script>
</body>

</html>