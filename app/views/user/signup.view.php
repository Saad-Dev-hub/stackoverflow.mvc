<?php include_once VIEWS_PATH.'includes'.DS.'mainheader.view.php'; ?>
<div class="app">
        <div class="shelter" >
            <div class="columns">
                <div class="col-4"></div>
                <div class="col-4">
                    <div class="py-2">
                        <h1 class="text-center logo"><a class="text-blue" href="/index">Kommunity</a></h1>
                        <h2 class="text-center text-grey">Sign up to Kommunity</h2>
                        <div class="form-card">
                            <form id="signup" method="POST" enctype="multipart/form-data">
                                <span class="js__errormsg"></span>
                                <?php if (!empty($errors)) { ?>
                                    <div class="alert alert-danger">
                                        <?php foreach ($errors as $error) { ?>
                                            <ul>
                                                <li><?php echo $error; ?></li>
                                            </ul>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($_errors_img)) { ?>
                                    <div class="alert alert-danger">
                                        <?php foreach ($_errors_img as $error) { ?>
                                            <ul>
                                                <li><?php echo $error; ?></li>
                                            </ul>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($user_exist)) {?>
                                    <div class="alert alert-danger">
                                            <ul>
                                                <li><?php print_r( $user_exist); ?></li>
                                            </ul>
                                    </div>
                                <?php } ?>

                                <div class="form-row">
                                    <label for="name">Username:</label>
                                    <input type="text" class="form-control" name="username" placeholder="Enter your username">
                                </div>
                                <div class="form-row">
                                    <label for="name">Email:</label>
                                    <input type="email" class="form-control" name="email" placeholder="Enter your email" >
                                </div>
                                <div class="form-row">
                                    <label for="name">Password</label>
                                    <input type="password" class="form-control" name="password"  placeholder="password">
                                </div>
                                <div class="form-row">
                                    <label for="name">Confirm Password</label>
                                    <input type="password" class="form-control" name="confirm-password"  placeholder="password">
                                </div>
                                <div class="form-row">
                                    <label for="file-upload" class="custom-file-upload">
                                        <i class="fa fa-cloud-upload"></i> Custom Upload
                                    </label>
                                    <input id="file-upload" name="photo" type="file" />
                                </div>
                                <input type="submit" name="submit" class="btnsub" value="Sign up">
                            </form>

                        </div>
                        <div class="other__option">
                            Already have an account? <a class="text-blue" href="/user/signin">Sign In</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php include_once VIEWS_PATH.'includes'.DS.'footer.view.php'; ?>