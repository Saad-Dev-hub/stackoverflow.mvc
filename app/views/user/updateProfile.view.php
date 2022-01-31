<?php include_once VIEWS_PATH . 'includes' . DS . 'header.view.php'; ?>
<?php include_once VIEWS_PATH . 'includes' . DS . 'nav.view.php'; ?>
<div class="container mar" style="width: 600px; margin-left: 340px;">
  <div class="row">
    <div class="col-md-3">
      <form method="POST" role="form" enctype="multipart/form-data">
        <div class="text-center">
          <img src="/<?= $_SESSION['loggedUser']->photo ?>" class="avatar img-circle img-thumbnail" alt="avatar">
          <h5>Upload a different photo...</h5>
          <?php if (isset($email_error)) { ?>
            <div class="alert alert-danger">
              <p><?php print_r($email_error); ?></p>
            </div>
          <?php } ?>
          <?php if (isset($username_error)) { ?>
            <div class="alert alert-danger">
              <p><?php print_r($username_error); ?></p>
            </div>
          <?php } ?>
          <?php if (isset($errors) && !empty($errors)) { ?>
            <div class="alert alert-danger">
              <?php foreach ($errors as $error) { ?>
                <p><?= $error ?></p>
              <?php } ?>
            </div>
          <?php } ?>
          <?php if(isset($errors_img) && !empty($errors_img)){ ?>
            <div class="alert alert-danger">
              <?php foreach ($errors_img as $error) { ?>
                <p><?= $error ?></p>
              <?php } ?>
            </div>
          <?php } ?>
          <input type="file" name="photo" class="form-control">
        </div>
    </div>

    <!-- edit form column -->
    <div class="col-md-9 personal-info">
      <h3>Personal info</h3>
      <div class="form-group">
        <label class="col-lg-3 control-label">User Name : </label>
        <div class="col-lg-8">
          <input class="form-control" name="username" type="text" placeholder="Username" value="<?= $_SESSION['loggedUser']->username ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 control-label" style="margin-top: 10px;">Email:</label>
        <div class="col-lg-8">
          <input class="form-control" type="email" name="email" value="<?= $_SESSION['loggedUser']->email ?>">
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label"></label>
        <div class="col-md-8">
          <input style="margin-left:240px ;" type="submit" name="submit" class="btn btn-blue ripple" value="Save Changes">
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
  </body>

  </html>