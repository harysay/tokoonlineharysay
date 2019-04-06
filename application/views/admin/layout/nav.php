 <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>

        <!-- MENU DASHBOARD -->
        <li><a href="<?php echo base_url('admin/dashboard') ?>"><i class="fa fa-dashboard text-aqua"></i> <span>DASHBOARD</span></a></li>

        <!-- MENU USER -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-lock"></i> <span>PENGGUNA</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('admin/user') ?>"><i class="fa fa-table"></i> Data Pengguna</a></li>
            <li><a href="<?php echo base_url('admin/user/tambah') ?>"><i class="fa fa-plus"></i> Tambah Pengguna</a></li>
          </ul>
        </li>
        <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Tentang Aplikasi</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $title ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">