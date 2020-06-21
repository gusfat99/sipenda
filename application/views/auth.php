<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Login</title>

  <!-- Bootstrap -->
  <link href="<?= base_url(); ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="<?= base_url(); ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="<?= base_url(); ?>vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- Animate.css -->
  <link href="<?= base_url(); ?>vendors/animate.css/animate.min.css" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>build/css/auth.css">
  <!-- PNotify -->
  <link href="<?= base_url(); ?>vendors/pnotify/dist/pnotify.css" rel="stylesheet">
  <link href="<?= base_url(); ?>vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
  <link href="<?= base_url(); ?>vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
  <!-- Custom Theme Style -->
  <link href="<?= base_url(); ?>build/css/custom.css" rel="stylesheet">
</head>

<body class="login">
  <div>
    <?= $this->session->userdata('notif') ? (
      '<div class="alert" data=" '. $this->session->flashdata("notif") .' "></div>'
    ) : '' ?>
    
    <div class="login_wrapper">
      <div class="marquee">
        <marquee>Selamat Datang Silahkan Login</marquee>
      </div>
      <div class="animate form login_form">

        <section class="login_content">
          <form id="formLogin" action="" method="POST" autocomplete="off">
            <img class="auth-logo" src="<?= base_url("src/assets/img/pdgw.jpg") ?>">
            <hr>
            <div class="form-group row has-feedback">
              <div class="col-md-12 col-sm-12">
                <input type="text" class="form-control has-feedback-left" name="user"  autofocus  placeholder="Username" required="required">
                <span class="fa fa-user form-control-feedback left"></span>
              </div>
            </div>
            <div class="form-group row has-feedback">
              <div class="col-md-12 col-sm-12">
                <input type="password" class="form-control has-feedback-left" name="pw" placeholder="Password" required="required">
                <span class="fa fa-key form-control-feedback left"></span>
              </div>
            </div>
            <div>
              <button type="submit" class="btn btn-default submit">Log in</button>
            </div>
            <div class="clearfix"></div>
            <div class="separator">
              <div class="clearfix"></div>
              <br />
            </div>
          </form>
        </section>
      </div>
    </div>
  </div>
</body>
</html>
<!-- jQuery -->
<script src="<?= base_url(); ?>vendors/jquery/dist/jquery.min.js"></script>
<!-- validate  -->
<script src="<?= base_url(); ?>vendors/validation/dist/jquery.validate.js"></script>
<!-- PNotify -->
<script src="<?= base_url(); ?>vendors/pnotify/dist/pnotify.js"></script>
<script src="<?= base_url(); ?>vendors/pnotify/dist/pnotify.buttons.js"></script>
<script src="<?= base_url(); ?>vendors/pnotify/dist/pnotify.nonblock.js"></script>
<script>
  $("form").validate({
    submitHandler : async (a, e) => {
      e.preventDefault();

     
      const post =  await $.ajax({
        url :  `<?= base_url("auth/authenticate"); ?>`,
        dataType : "json",
        type : "POST",
        data : $("form#formLogin").serialize()
      });

      if (post.auth) {
        new PNotify({
          text: post.message,
          type : 'success',
          styling: 'bootstrap3'
        });
        document.location.href = '<?= base_url(); ?>';
      } else {
        new PNotify({
          text: post.message,
          type : 'danger',
          styling: 'bootstrap3'
        });

      }
    },
    rules : {
      user : {
        required : true,
        minlength: 5
      },
      pw : {
        required : true,
        minlength : 6
      }
    }
  });

  const alert = $(".alert").attr("data");
  if (alert) {
    new PNotify({
      text: alert,
      type : 'success',
      styling: 'bootstrap3'
    });
  }

</script>