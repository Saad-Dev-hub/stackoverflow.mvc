<?php include_once VIEWS_PATH . 'includes' . DS . 'headerQuestion.view.php'; ?>
<?php include_once VIEWS_PATH . 'includes' . DS . 'nav.view.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Ask Question</h1>
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
                    <label for="title">Title:</label>
  <input type="text" class="form-control" name="title" id="title" placeholder="Please, provide a brief and straight-forward title to your question" value="<?= $editedQuestion->title ?>">
                </div>
                <div class="form-group">
                    <label for="body">Body:</label>
                    <textarea class="form-control" name="body" id="body" value="<?=htmlspecialchars_decode($editedQuestion->body);?>"></textarea>
                </div>
                <div class="form-group">
                    <label for="tags">Select Tag:</label>
                    <select class="form-control" name="tag" id="tags">
                        <option value="">Select a tag</option>
                        <option value="php">PHP</option>
                        <option value="javascript">Javascript</option>
                        <option value="html">HTML</option>
                        <option value="css">CSS</option>
                        <option value="mysql">MySQL</option>
                        <option value="sql">SQL</option>
                        <option value="c#">C#</option>
                        <option value="c++">C++</option>
                        <option value="c">C</option>
                        <option value="java">Java</option>
                        <option value="python">Python</option>
                        <option value="ruby">Ruby</option>
                        <option value="php">PHP</option>
                        <option value="javascript">Javascript</option>
                        <option value="html">HTML</option>
                        <option value="css">CSS</option>
                        <option value="mysql">MySQL</option>
                        <option value="sql">SQL</option>
                        <option value="c#">C#</option>
                        <option value="c++">C++</option>
                        <option value="c">C</option>
                        <option value="java">Java</option>
                        <option value="python">Python</option>
                        <option value="ruby">Ruby</option>
                    </select>
                    <button type="submit" name="submit" class="btn btn-info mt-1">Update Question</button>
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