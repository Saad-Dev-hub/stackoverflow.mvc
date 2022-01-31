<?php include_once VIEWS_PATH.'includes'.DS.'mainheader.view.php'; ?>
<div class="app">
   <div class="shelter">
       <div class="columns">
           <div class="col-4"></div>
           <div class="col-4">
               <div class="py-2">
                    <h1 class="text-center"><a class="text-blue logo" href="/index">Kommunity</a></h1>
                    <h2 class="text-center text-grey">Sign in to Kommunity</h2>
                    <div class="form-card">       
                        <form id="signup" method="POST">
                            <?php if (!empty($user_not_exist)) { ?>
                                <div class="alert alert-danger">
                                        <?php print_r($user_not_exist); ?>
                                </div>
                            <?php } ?>
                            <?php if (!empty($password_error)) { ?>
                                <div class="alert alert-danger">
                                <?php  print_r($password_error); ?>
                                </div>
                            <?php } ?>
                            <span class="js__errormsg"></span>
                            <div class="form-row">
                                <label for="name">Email:</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter your email" required minlength="3" maxlength="30">
                            </div>
                            <div class="form-row">
                                <label for="name">Password</label>
                                <input type="password" class="form-control" name="password" required placeholder="password">
                            </div>
                            <div class="form-row">
                                <button type="submit" class="btn btn-block btn-blue ripple" name="submit">Sign in</button>
                            </div>
                        </form>
                    </div>
                    <div class="text-left">
                        <a href="/user/forgetPassword">Forget Password</a>
                    </div>
                    <div class="other__option">
                        Don't have an account yet? <a class="text-blue" href="/user/signup">Create Account</a>
                    </div>
               </div>
               
           </div>
           <div class="col-4"></div>
       </div>
   </div>
   </div>
<?php include_once VIEWS_PATH.'includes'.DS.'footer.view.php'; ?>
