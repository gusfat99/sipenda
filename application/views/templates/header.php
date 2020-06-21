<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>SIPENDA</title>

  <style type="text/css">
    form span.error {
      color : red;
      },
      form input.error {
        border: 1px solid red !important;
        border-radius: 10px !important;
      }
    </style>

    <!-- Bootstrap -->
    <link href="<?= base_url(); ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?= base_url(); ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?= base_url(); ?>vendors/nprogress/nprogress.css" rel="stylesheet">
    <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'>

    <!-- Optional SmartWizard theme -->
    <link href="<?= base_url(); ?>vendors/smartwizard/dist/css/smart_wizard_theme_circles.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>vendors/smartwizard/dist/css/smart_wizard_theme_arrows.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>vendors/smartwizard/dist/css/smart_wizard_theme_dots.css" rel="stylesheet" type="text/css" />

    <!-- Datatables -->
    
    <link href="<?= base_url(); ?>vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- PNotify -->
    <link href="<?= base_url(); ?>vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="<?= base_url(); ?>vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="<?= base_url(); ?>vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="<?= base_url(); ?>vendors/jquery/dist/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" ></script>
    
    <!-- jQuery Smart Wizard -->
    <script src="<?= base_url(); ?>vendors/smartwizard/dist/js/jquery.smartWizard.min.js"></script>
    <!-- Custom Theme Style -->
    <link href="<?= base_url(); ?>build/css/custom.css" rel="stylesheet">

    <!-- validate  -->
    <script src="<?= base_url(); ?>vendors/validation/dist/jquery.validate.js"></script>

    <!-- select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <!-- sweet alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Datatables -->
    <script src="<?= base_url(); ?>vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url(); ?>vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?= base_url(); ?>vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= base_url(); ?>vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?= base_url(); ?>vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="<?= base_url(); ?>vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?= base_url(); ?>vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="<?= base_url(); ?>vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="<?= base_url(); ?>vendors/jszip/dist/jszip.min.js"></script>
    <script src="<?= base_url(); ?>vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?= base_url(); ?>vendors/pdfmake/build/vfs_fonts.js"></script>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3  left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?= base_url(); ?>" class="site_title"><i class="fa fa-trophy"></i> <span>SIPENDA</span></a>
            </div>
            

            

            <!-- menu profile quick info -->
            <div align="center" class="profile clearfix">
              <div class="profile_pic">
                <img src="<?= base_url('src/assets/img/pdgw.jpg') ?>"  class="img-circle profile_img">
              </div>
            </div>
            <!-- /menu profile quick info -->
