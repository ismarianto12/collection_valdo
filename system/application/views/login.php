<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Deb Collection Manangement</title>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="robots" content="noindex, nofollow">
  <meta name="googlebot" content="noindex, nofollow">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="/css/result-light.css">

  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/cnn/bootstrap4.min.css">
  <script src="<?= base_url() ?>assets/cnn/jquery.min.js"></script>
  <script type="text/javascript" src="<?= base_url() ?>assets/cnn/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script type="text/javascript" src="<?= base_url() ?>assets/cnn/dialog/bootbox.js"></script>
  <script>
    function base_url() {
      return '<?= base_url() ?>';
    }
  </script>

  <style id="compiled-css" type="text/css">
    /*
*
* ==========================================
* CUSTOM UTIL CLASSES
* ==========================================
*
*/

    .border-md {
      border-width: 2px;
    }

    .btn-facebook {
      background: #405D9D;
      border: none;
    }

    .btn-facebook:hover,
    .btn-facebook:focus {
      background: #314879;
    }

    .btn-twitter {
      background: #42AEEC;
      border: none;
    }

    .btn-twitter:hover,
    .btn-twitter:focus {
      background: #1799e4;
    }

    body {
      min-height: 100vh;
    }

    .form-control:not(select) {
      padding: 1.5rem 0.5rem;
    }

    select.form-control {
      height: 52px;
      padding-left: 0.5rem;
    }

    .form-control::placeholder {
      color: #ccc;
      font-weight: bold;
      font-size: 0.9rem;
    }

    .form-control:focus {
      box-shadow: none;
    }

    /* EOS */
  </style>

  <script id="insert"></script>


</head>

<body>
  <header class="header">
    <nav class="navbar navbar-expand-lg navbar-light py-3">
      <div class="container">
        <a href="#" class="navbar-brand" style="float:center">
          <center>
            <img src="<?= base_url() ?>/assets/images/valdo_new.png" alt="logo" width="150">
          </center>
        </a>
      </div>
    </nav>
    <br />
  </header>
  <div class="container">
    <div class="row">

      <div class="col-md-8 align-items-center">
        <center>
          <img src="<?= base_url() ?>/assets/images/illustration.svg" alt="" class="img-fluid mb-3 d-none d-md-block" style="width:50%">
          <h1>Deb Collection Manangement</h1>
          </p>
        </center>
      </div>
      <div class="col-md-4" style="margin-top:-80px">
        <center>
          <img src="<?= base_url() ?>/assets/images/logo.png" class="img-responsive" style="width: auto;">
        </center>
        <br />

        <div id="ket"></div>
        <br />
        <form action="<?= site_url('login/logg') ?>" id="loginform" method="post">
          <input type="hidden" id="post" name="post" value="post" />
          <div class="row">
            <div class="input-group col-lg-12 mb-4">
              <div class="input-group-prepend">
                <span class="input-group-text bg-white px-4 border-md border-right-0">
                  <i class="fa fa-user text-muted"></i>
                </span>
              </div>
              <input id="username" type="text" name="username" placeholder="Username" class="form-control bg-white border-left-0 border-md">
            </div>

            <div class="input-group col-lg-12 mb-4">
              <div class="input-group-prepend">
                <span class="input-group-text bg-white px-4 border-md border-right-0">
                  <i class="fa fa-users text-muted"></i>
                </span>
              </div>
              <input id="password" type="password" name="password" placeholder="Password" class="form-control bg-white border-left-0 border-md">
            </div>

            <!-- Submit Button -->
            <div class="form-group col-lg-12 mx-auto mb-0">
              <button class="btn btn-primary btn-block py-2" type="submit">
                <span class="font-weight-bold">Login</span>
              </button>
            </div>

            <div class="text-center w-100">
              <br /> <br />
              <p class="text-muted font-weight-bold">Lupa Password? <a href="#" class="text-primary ml-2"></a></p>
            </div>
          </div>
        </form>
      </div>

    </div>
  </div>
  </div>

  <script type="text/javascript">
    $(function() {
      $('#loginform').on('submit', function(e) {
        e.preventDefault();
        var username = $('#username').val();
        var password = $('#password').val();

        $.ajax({
          url: $(this).attr('action'),
          data: $(this).serialize(),
          method: 'POST',
          chace: false,
          asynch: false,
          dataType: 'json',
          success: function(data) {
            window.location.href = '<?= base_url() ?>';
          },
          error: function(data) {
            $('#ket').html('<div class="alert alert-danger">Username dan password salah</div>');
          }
        })
      });
    });
  </script>

  <script>
    // For Demo Purpose [Changing input group text on focus]
    $(function() {
      $('input, select').on('focus', function() {
        $(this).parent().find('.input-group-text').css('border-color', '#80bdff');
      });
      $('input, select').on('blur', function() {
        $(this).parent().find('.input-group-text').css('border-color', '#ced4da');
      });
    });
  </script>

</body>


</html>