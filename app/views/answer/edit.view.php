<?php include_once VIEWS_PATH . 'includes' . DS . 'headerQuestion.view.php'; ?>
<?php include_once VIEWS_PATH . 'includes' . DS . 'nav.view.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Edit Your Answer</h2>
            <?php if (isset($errors) && !empty($errors)) : ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error) : ?>
                            <li><?= $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form method="post">
                <div class="form-group">
                    <label for="body">Body:</label>
                    <textarea class="form-control" name="body" id="body"><?=htmlspecialchars_decode($myAnswer->body);?></textarea>
                </div>
                    <button type="submit" name="submit" class="btn btn-info mt-1">Update Answer</button>
            </form>
        </div>
    </div>
</div>
<script>
    $('#body').summernote({
        placeholder: 'Write your question here...',
        tabsize: 2,
        height: 300
        // change background color of code view


    });
</script>
</body>

</html>