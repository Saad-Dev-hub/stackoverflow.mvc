<!doctype html>
<html lang="en">
<head>
    <title><?=$pageTitle?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="icon" href="/assets/images/chatting.png" type="image/gif" sizes="16x16">

    <style>
        .form-gap {
            padding-top: 70px;
        }
    </style>
</head>
<body>
    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Forgot Password?</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">
                                <?php if(isset($user_not_exist)) { ?>
                                    <div class="alert alert-danger">
                                          <b><?php print_r( $user_not_exist); ?></b>
                                    </div>
                                <?php } ?>
                                <?php if(isset($errors )) { ?>
                                <?php foreach($errors as $error) { ?>
                                    <div class="alert alert-danger">
                                          <b><?php print_r( $error); ?></b>
                                    </div>
                                <?php } ?>
                                <?php } ?>
                                <form id="register-form" role="form" autocomplete="off" class="form" method="POST">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                            <input id="email" name="email" placeholder="email address" class="form-control" type="email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input name="submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
</body>

</html>