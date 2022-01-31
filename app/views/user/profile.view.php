<?php include_once VIEWS_PATH . 'includes' . DS . 'header.view.php'; ?>
<?php include_once VIEWS_PATH . 'includes' . DS . 'nav.view.php'; ?>
<section class="py-5">
    <div class="shelter">
        <div class="ddd">
            <div class="columns">
                <div class="col-md-4">
                    <figure class="snip1515">
                        <div class="profile-image"><img src="/<?= $_SESSION['loggedUser']->photo ?>" alt="profile" /></div>
                        <figcaption>
                            <h3><?= $_SESSION['loggedUser']->username ?></h3>
                            <h4><b><?= $_SESSION['loggedUser']->email ?></b></h4>
                            <div class="icons"><a href="#"><i class="ion-social-reddit"></i></a>
                                <a href="#"> <i class="ion-social-twitter"></i></a>
                                <a href="#"> <i class="ion-social-vimeo"></i></a>
                            </div>
                        </figcaption>
                        <a href="/user/updateProfile" class="btn btn-blue ripple">Update Profile</a>
                    </figure>

                </div>
                <div class="col-6">
                    <div class="card p-1">
                        <span class="text-grey"><b>Recent Questions</b></span>
                    </div>
                    <?php if (empty($userQuestions)) : ?>
                        <div class="card p-1">
                            <span class="text-grey">No questions yet</span>
                        </div>
                    <?php else : ?>
                    <?php foreach ($userQuestions as $question) : ?>
                            <div class="card p-1">
                                <a href="/question/show/<?=$question->id ?>"><b><?= $question->title ?></b></a>
                            </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>