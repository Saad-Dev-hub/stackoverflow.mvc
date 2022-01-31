<?php include_once VIEWS_PATH . 'includes' . DS . 'headerQuestion.view.php'; ?>
<?php include_once VIEWS_PATH . 'includes' . DS . 'nav.view.php'; ?>
<div class="app">
    <section class="py-3">
        <div class="shelter">
            <div class="ddd mt-2">
                <div class="columns">
                    <div class="col-7">
                        <div class="card p-1">
                            <div class="card-question">
                                <h3> <?= $question->title; ?> </h3>
                            </div>
                            <div class="justify-content-start">
                                <div class="card-user">
                                    <img class="avatar1" src="/<?= $user->photo ?>">
                                </div>
                                <div class="card-user__job flex">
                                    <span> <b><?= $user->username; ?></b></span>
                                    <span>
                                        <time class="timeago ml-1" datetime="<?= $question->updated_at ?>"> <?= date($question->updated_at) ?></time> &nbsp;&nbsp;&nbsp; <?= date("d/m/Y", strtotime($question->updated_at)); ?>
                                        <small class="text-grey"></small>
                                    </span>
                                </div>
                            </div>

                            <div class="card-description">
                                <?= html_entity_decode($question->body) ?>
                            </div>
                            <a href="/question/edit/<?= $question->id; ?>" class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"> Edit<i class="fa fa-edit"></i></a>
                            <a href="/question/delete/<?= $question->id; ?>" onclick="return confirm('Are you sure you want to delete this Question?');" class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"> Delete<i class="fa fa-trash"></i></a>
                        </div>
                        <div class="answer-count">
                            <h1><?= ($answers_count->count) == 0 ? 'No Answers Yet' : $answers_count->count . 'Answers'; ?></h1>
                        </div>

                        <?php if (isset($answers) && !empty($answers)) : ?>
                            <?php foreach ($answers as $answer) : ?>
                                <div class="justify-content-start position-relative">
                                    <div class="upvote  upvote-enabled" id="u0">
                                        <a href="/vote/upvote/<?= $answer->id; ?>/<?= $question->id; ?>" class="upvote" title="This Answer is useful"></a>
                                        <?php if ($answer->NumberOfVotes !== null) : ?>
                                            <span id="count"><?= $answer->NumberOfVotes ?></span>
                                        <?php else : ?>
                                            <span id="count"><?= 0 ?></span>
                                        <?php endif; ?>
                                        <a href="/vote/downvote/<?= $answer->id; ?>/<?= $question->id; ?>" class="downvote " title="This Answer is not useful"></a>
                                    </div>
                                    <div class="card-user">
                                        <img class="avatar1" src="/<?= $answer->photo; ?>">
                                    </div>
                                    <div class="card-user__job flex">
                                        <span class="pl-2"><b><?= $answer->username; ?></b></span>
                                        <span>
                                            <small class="text-grey"><time class="timeago ml-1" datetime="<?= $answer->updated_at ?>"> <?= date($answer->updated_at) ?></time> &nbsp;&nbsp;&nbsp; <?= date("d/m/Y", strtotime($answer->updated_at)); ?></small>
                                        </span>
                                    </div>
                                </div>
                                <div class="answer-text">
                                    <?= htmlspecialchars_decode($answer->body) ?>
                                </div>
                                <?php if ($answer->user_id == $_SESSION['loggedUser']->id) : ?>
                                    <div class=" mb-3">
                                        <a href="/answer/edit/<?= $answer->id; ?>" class="btn btn-success btn-sm rounded-0 mb-3" type="button" data-toggle="tooltip" data-placement="top" title="Edit"> Edit<i class="fa fa-edit"></i></a>
                                        <a href="/answer/delete/<?= $answer->id; ?>" onclick="return confirm('Are you sure you want to delete this Answer?');" class="btn btn-danger btn-sm rounded-0 mb-3" type="button" data-toggle="tooltip" data-placement="top" title="Delete"> Delete<i class="fa fa-trash"></i></a>
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
    <div style="max-width: 808px;">
        <form method="POST">
            <h2 class="ml-6">Your Answer</h2>
            <?php if (isset($errors) && count($errors) > 0) : ?>
                <div>
                    <?php foreach ($errors as $error) : ?>
                        <?= '<div class="bodyError">' . $error . '</div>' ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="ml-6">
                <textarea class="form-control" name="body" id="body"></textarea>
            </div>
            <input class="btn btn-blue ripple ml-6" type="submit" value="Post Your Answer" name="submit">
        </form>
    </div>

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