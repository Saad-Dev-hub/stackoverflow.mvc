<div class="app">
    <div class="header" id="header">
        <div class="navbar fixed-top" id="navbar">
            <div class="shelter">
                <a class="navbar__nav nav__logo nav__underline" href="/">
                   <span>K</span>ommunity
                </a>
                <div class="navbar__nav navbar__nav-toggle">
                    <i class="fa fa-bars"></i>
                </div>
                <nav class="nav__items">
                    <div class="navbar__nav nav__underline">
                        <a href="/" class="nav__link active">
                            <i class="fa fa-home p-r-5"></i>
                            Home
                        </a>   
                    </div>
                    <div class="navbar__nav nav__underline p__8">
                    <div class="search">
                        <input class="form-control" type="text" placeholder="Search for Questions">
                    </div>
                    </div> 
                    <?php if(isset($_SESSION['loggedUser'])): ?>
                    <div class="navbar__nav nav__underline p__8">
                        <a href="/question/ask"  class="btn btn-blue ripple" title="click to ask question"><b>Ask a Question</b></a>
                        <!-- <button type="button" class="btn btn-blue ripple" id="modalBtn" title="click to ask question">Ask a Question <i class="fa fa-plus"></i></button> -->
                    </div>
                    <?php else :?>
                    <div class="navbar__nav nav__underline p__8">
                        <a href="/user/signin" onclick="return confirm('You Must Login First To Ask Any Question?')" class="btn btn-blue ripple" title="click to ask question"><b>Ask a Question</b></a>
                        <!-- <button type="button" class="btn btn-blue ripple" id="modalBtn" title="click to ask question">Ask a Question <i class="fa fa-plus"></i></button> -->
                    </div>
                    <?php endif; ?>
                </nav>
                <?php if (isset($_SESSION['loggedUser'])) { ?>
                    <nav class="nav__items nav__items-right">
                        <div class="navbar__nav pr-0 p__8 dropdown">
                            <a href="#"><img src="/<?=$_SESSION['loggedUser']->photo ?>" class="avatar-sm" title="Profile"></a>
                            <div class="dropdown-content">
                                <a href="/user/logout">Log out <i class="fa fa-power-off"></i></a>
                                <a href="/user/profile">Profile <i class="fa fa-user-o"></i></a>
                            </div>
                        </div>
                    </nav>
                <?php } else { ?>
                <nav class="nav__items nav__items-right">
                    <div class="navbar__nav pr-0 p__8">
                        <a href="/user/signup">
                            <button type="button" class="btn btn-colorless" id="loginBtn">Sign Up <i class="fa fa-dashcube"></i></button>
                        </a>
                    </div>
                    <div class="navbar__nav pr-0 p__8">
                        <a href="/user/signin">
                            <button type="button" class="btn btn-colorless" id="loginBtn">Login <i class="fa fa-chevron-circle-right"></i></button>
                        </a>
                    </div>
                </nav>
                <?php } ?>
            </div><!--end container-->
        </div><!--end navbar-->
       
    </div><!--end header-->