<?php include_once VIEWS_PATH . 'includes' . DS . 'header.view.php'; ?>
<?php include_once VIEWS_PATH . 'includes' . DS . 'nav.view.php'; ?>
<?php include_once VIEWS_PATH . 'includes' . DS . 'main.view.php'; ?>
<?php require_once  '..' . DS . 'vendor' . DS . 'stefangabos' . DS . 'zebra_pagination' . DS . 'Zebra_Pagination.php'; ?>
<section class="py-2">
    <div class="shelter">
        <div>
            <div class="columns">
                <div class="col-2">
                    <div class="left-side">
                        <h1>Activity</h1>
                        <div class="left-side__item active2">
                            <a class="side-link" href="question.html"><span class="pr-1"><i class="fa fa-pencil"></i></span> Questions</a>
                        </div>
                        <div class="left-side__item">
                            <a class="side-link" href="#"><span class="pr-1"><i class="fa fa-book"></i></span> Answers</a>
                        </div>
                    </div>
    
                </div>
                <div class="col-7">
                    <div class="d-flex">
                    <div class="carded p-1">
                        <span>Recent Questions</span>
                    </div>
                   
                    </div>
                    <?php foreach ($allQuestions as $question) : ?>
                        <div class="card p-1">
                            <div class="card-question">
                                <a href="/index/showQuestion/<?= $question->id?>"><?= $question->title ?></a>
                                <div class="card-hide" id="card-hide">
                                    <i class="fa fa-ellipsis-h"></i>
                                </div>
                            </div>
                            <div class="card-drop" id="card-drop">
                                <a class=""><i class="fa fa-pencil"></i> Edit Question</a>
                                <a class=""><i class="fa fa-times"></i> Delete Question</a>
                                <a class=""><i class="fa fa-map-pin"></i> Pin Question</a>
                                <a class=""><i class="fa fa-share"></i> Share Question</a>
                            </div>
                            <div class="justify-content-start">
                                <div class="card-user">
                                    <img class="avatar1" src="/<?= $question->photo ?>">
                                </div>
                                <div class="card-user__job flex">
                                    <span class="pl-2"><?= $question->username ?></span>
                                    <span>
                                        <small class="text-grey"> <time class="timeago ml-1" datetime="<?= $question->updated_at ?>"> <?= date($question->updated_at) ?></time> 
                                        </small> &nbsp;&nbsp;&nbsp; <small class="text-gray"><?= date("d/m/Y", strtotime($question->created_at)); ?></small>
                                        
                                    </span>
                                </div>
                            </div>
                            <div class="card-description description ellipsis">
                                <p><?= (htmlspecialchars_decode($question->body, ENT_QUOTES)); ?>

                                </p>
                            </div>
                            <div class="card-reaction justify-content-space-between">
                                <div class="card-views">
                                <div class="card-btn">
                                        <span><?= $question->NumberOfAnswers ?> Answers</span> <i class="fa fa-pencil"></i>

                                    </div>
                                </div>
                                <div class="card-answer ml-2">
           
                                </div>
                                <div class="card-tag ml-2">
                                    <div class="card-btn"><span><?= $question->category ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
                <div class="col-3">
                    <div class="right-card">
                        <span>Top Contributors</span>
                        <p></p>
                        <?php foreach($topContributors as $topContributor) : ?>
                        <div class="top-contributor">
                            <div>
                                <img class="avatar-sm" src="/<?=$topContributor->photo ?>">
                            </div>
                            <span class="flex"><?=$topContributor->username ?></span>
                            <div class="flex">
                                <span> <i class="fa fa-comment-o"></i> <?=$topContributor->NumberOfAnswers ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
<?php $pagination->render();?>
<?php include_once VIEWS_PATH . 'includes' . DS . 'footer.view.php'; ?>

<script>
    var spans = $('.card-description span');
    var divs = $('.card-description div');
    var pres = $('pre');
    spans.contents().unwrap();
    pres.contents().unwrap();
    divs.contents().unwrap();
    $(".card-description *").filter(function() {
        return $.trim($(this).html()) == '';
    }).remove();
    jQuery(document).ready(function() {
        jQuery("time.timeago").timeago();
    });
</script>
