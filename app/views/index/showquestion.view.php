<?php include_once VIEWS_PATH . 'includes' . DS . 'headerQuestion.view.php'; ?>
<?php include_once VIEWS_PATH . 'includes' . DS . 'nav.view.php'; ?>
<div class="app">
    <section class="py-3">
        <div class="shelter">
            <div class="ddd mt-2">
                <div class="columns">
                    <div class="col-7">
                        <div class="card p-1">
                            <?php
                            if (isset($_SESSION['voteError'])) {
                                echo $_SESSION['voteError'];
                                unset($_SESSION['voteError']);
                            }
                              ?>
                            <div class="card-question">
                                <?php foreach ($Question as $question) : ?>
                                    <h3> <?= $question->title; ?> </h3>
                            </div>
                            <div class="justify-content-start">
                                <div class="card-user">
                                    <img class="avatar1" src="/<?= $userWhoAskedTheQuestion->photo ?>">
                                </div>
                                <div class="card-user__job flex">
                                    <span> <b><?= $userWhoAskedTheQuestion->username; ?></b></span>
                                    <span>
                                        <time class="timeago ml-1" datetime="<?= $question->updated_at ?>"> <?= date($question->updated_at) ?></time> &nbsp;&nbsp;&nbsp; <?= date("d/m/Y", strtotime($question->updated_at)); ?>
                                        <small class="text-grey"></small>
                                    </span>
                                </div>
                            </div>

                            <div class="card-description">
                                <?= html_entity_decode($question->body) ?>
                            </div>
                            <?php if (!isset($_SESSION['loggedUser'])) : ?>
                                <div>
                                </div>
                            <?php else : ?>
                                <?php if ($question->user_id == $_SESSION['loggedUser']->id) : ?>
                                    <a href="/question/edit/<?= $question->id; ?>" class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"> Edit<i class="fa fa-edit"></i></a>
                                    <a href="/question/delete/<?= $question->id; ?>" onclick="return confirm('Are you sure you want to delete this Question?');" class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"> Delete<i class="fa fa-trash"></i></a>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        </div>
                        <div class="answer-count">
                            
                            <h1><?php if (empty($answersForCurrentQuestion)) : ?>
                                    No Answers Yet</h1>
                        <?php else : ?>
                            <?= count($answersForCurrentQuestion) ?>
                            Answers</h1>
                        <?php endif; ?>
                        </div>
                        <?php if (isset($answersForCurrentQuestion) && !empty($answersForCurrentQuestion)) : ?>
                            <?php foreach ($answersForCurrentQuestion as $answer) : ?>
                                <?php if ($answer->id !== null) : ?>
                                    <div class="justify-content-start position-relative">

                                        <?php if (!isset($_SESSION['loggedUser'])) : ?>
                                            <div class="upvote  upvote-enabled" id="u0">
                                                <a href="/user/signin" onclick="return confirm('You Must Login First To Upvote This Question,Already Have Account?');" class="upvote" title="This Answer is useful"></a>
                                                <span id="count"><?= ($answer->NumberOfVotes) === null ? 0 : $answer->NumberOfVotes ?></span>
                                                <a href="/user/signin" onclick="return confirm('You Must Login First To Downvote This Question,Already Have Account?');" class="downvote" title="This Answer is not useful"></a>
                                            </div>
                                        <?php else : ?>
                                            <div class="upvote  upvote-enabled" id="u0">
                                                <a href="/vote/upvote/<?= $answer->id; ?>/<?= $question->id; ?>" class="upvote" title="This Answer is useful"></a>
                                                <span id="count"><?= ($answer->NumberOfVotes) == null ? 0 : $answer->NumberOfVotes ?></span>                                                
                                                <a href="/vote/downvote/<?= $answer->id; ?>/<?= $question->id; ?>" class="downvote " title="This Answer is not useful"></a>
                                            </div>
                                        <?php endif; ?>
                                        <div class="card-user">

                                            <img class="avatar2" src="/<?= $answer->photo; ?>">
                                        </div>
                                        <div class="card-user__job flex">
                                            <span class="ml-"><b><?= $answer->username; ?></b></span>
                                            <span>
                                                <small class="text-grey"><time class="timeago ml-1" datetime="<?= $answer->updated_at ?>"> <?= date($answer->updated_at) ?></time> &nbsp;&nbsp;&nbsp; <?= date("d/m/Y", strtotime($answer->updated_at)); ?></small>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="answer-text">
                                        <?= htmlspecialchars_decode($answer->body) ?>
                                    </div>
                                    <?php if (!isset($_SESSION['loggedUser'])) : ?>
                                        <div class="answer-txt">
                                        </div>
                                    <?php else : ?>

                                        <?php if ( $answer->user_id==$_SESSION['loggedUser']->id) : ?>
                                            <div class=" mb-3">
                                                <a href="/answer/edit/<?= $answer->id; ?>" class="btn btn-success btn-sm rounded-0 mb-3" type="button" data-toggle="tooltip" data-placement="top" title="Edit"> Edit<i class="fa fa-edit"></i></a>
                                                <a href="/answer/delete/<?= $answer->id; ?>" onclick="return confirm('Are you sure you want to delete this Answer?');" class="btn btn-danger btn-sm rounded-0 mb-3" type="button" data-toggle="tooltip" data-placement="top" title="Delete"> Delete<i class="fa fa-trash"></i></a>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                <?php else : ?>
                                    <div class="answer-txt">
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
</div>
</section>
<div class="py-3">
    <?php if (!isset($_SESSION['loggedUser'])) : ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div>
                        <div class="card-body">
                            <p class="card-text">Login to your account to post an answer</p>
                            <a href="/user/signin" class="btn btn-primary">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div style="max-width: 808px;">
            <form method="POST">
                <h2 class="ml-6">Your Answer</h2>
                <div class="ml-6">
                    <textarea class="form-control" name="body" id="body"></textarea>
                </div>
                <?php if (isset($errors) && count($errors) > 0) : ?>
                    <div>
                        <?php foreach ($errors as $error) : ?>
                            <?= '<div style="color:red" class="ml-6">' . $error . '</div>' ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <input class="btn btn-blue ripple ml-6" type="submit" value="Post Your Answer" name="submit">
            </form>
        </div>
    <?php endif; ?>

</div>

</div>
<?php include_once VIEWS_PATH . 'includes' . DS . 'footer.view.php'; ?>
<script>
    jQuery(document).ready(function() {
        jQuery("time.timeago").timeago();
    });
    $('#body').summernote({
        placeholder: 'Write your question here...',
        tabsize: 2,
        height: 300
    });
</script>
