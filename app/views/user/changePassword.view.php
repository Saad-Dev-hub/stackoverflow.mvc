<!doctype html>
<html lang="en">

<head>
    <title><?= $pageTitle ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- #region -->
    <style>
        html,
        body {
            min-height: 100%
        }

        body {
            background: #f6f6f6 url(https://goo.gl/1yhE3P) top center no-repeat;
            background-size: cover;
            font-family: "Open Sans", sans-serif;
            font-size: 14px;
            margin: 0
        }

        #box {
            width: 400px;
            margin: 10% auto;
            text-align: center;
            background: rgba(255, 255, 255, 0.6);
            padding: 20px 50px;
            box-sizing: border-box;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.2);
            border-radius: 2%
        }

        h1 {
            margin-bottom: 1.5em;
            font-size: 30px;
            color: #484548;
            font-weight: 100;
        }

        h1 span,
        small {
            display: block;
            font-size: 14px;
            color: #989598;
        }

        small {
            font-style: italic;
            font-size: 11px;
        }

        form p {
            position: relative;
        }

        .password {
            width: 90%;
            padding: 15px 12px;
            margin-bottom: 5px;
            border: 1px solid #e5e5e5;
            border-bottom: 2px solid #ddd;
            background: rgba(255, 255, 255, 0.2) !important;
            color: #555;
        }

        .password+.unmask {
            position: absolute;
            right: 5%;
            top: 10px;
            width: 25px;
            height: 25px;
            background: transparent;
            border-radius: 50%;
            cursor: pointer;
            border: none;
            font-family: 'fontawesome';
            font-size: 14px;
            line-height: 24px;
            -webkit-appearance: none;
            outline: none
        }

        .password+.unmask:before {
            content: "\f06e";
            position: absolute;
            top: 0;
            left: 0;
            width: 25px;
            height: 25px;
            background: rgba(205, 205, 205, 0.2);
            z-index: 1;
            color: #aaa;
            border: 2px solid;
            border-radius: 50%;
        }

        .password[type="text"]+.unmask:before {
            content: "\f070";
            background: rgba(105, 205, 255, 0.2);
            color: #06a
        }

        #valid {
            font-size: 12px;
            color: #daa;
            height: 15px
        }

        #strong {
            height: 20px;
            font-size: 12px;
            color: #daa;
            text-transform: capitalize;
            background: rgba(205, 205, 205, 0.1);
            border-radius: 5px;
            overflow: hidden
        }

        #strong span {
            display: block;
            box-shadow: 0 0 0 #fff inset;
            height: 100%;
            transition: all 0.8s
        }

        #strong .weak {
            box-shadow: 5em 0 0 #daa inset;
        }

        #strong .medium {
            color: #da6;
            box-shadow: 10em 0 0 #da6 inset
        }

        #strong .strong {
            color: #595;
            box-shadow: 50em 0 0 #ada inset
        }
    </style>
    <!-- #endregion -->
</head>

<body>
    <div id="box">
        <form id="myform-search" method="post" autocomplete="off">
            <h1>Change Password <span>choose a good one!</span></h1>
            <form method="POST">
                <?php if (isset($old_password)) : ?>
                <?php print_r("<div class='alert alert-danger'>" . $old_password . "</div>"); ?>
                <?php endif; ?>
                <?php if(isset($errors) && !empty($errors)) : ?>
                <?php foreach($errors as $error) : ?>
                <?php print_r("<div class='alert alert-danger'>" . $error . "</div>"); ?>
                <?php endforeach; ?>
                <?php endif; ?>
                <p>
                    <input type="password" name="password"  placeholder="Enter Password" id="p" class="password">
                </p>
                <p>
                    <input type="password" name="confirm_password" placeholder="Confirm Password" id="p-c" class="password">
                <div id="strong"><span></span></div>
                <div id="valid"></div>
                </p>
                <input class="btn btn-primary shadow-2 mb-4" type="submit" name="submit" value="Change Password" />

            </form>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>