<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Not Found</title>
    <style>

        @import url('https://fonts.googleapis.com/css?family=Roboto+Mono:300,500');

        html,
        body {
            height: 100%;
        }

        body {
            background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/257418/andy-holmes-698828-unsplash.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            font-family: "Roboto Mono", "Liberation Mono", Consolas, monospace;
            color: rgba(255, 255, 255, .87);
            overflow: hidden;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .container,
        .container>.row,
        .container>.row>div {
            height: 100%;
        }

        #countUp {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .number {
            font-size: 4rem;
            font-weight: 500;
        }

        .text {
            margin: 0 0 1rem;
        }


        .text {
            font-weight: 300;
            text-align: center;
        }
    </style>
</head>

<body onload="number();">
    <div class="container">
        <div class="row">
            <div class="xs-12 md-6 mx-auto">
                <div id="countUp">
                    <div class="number" id="number">0</div>
                    <div class="text">Page not found</div>
                    <div class="text">This may not mean anything.</div>
                    <div class="text">I'm probably working on something that has blown up.</div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function number() {
            var number = document.getElementById('number');
            var i = 0;
            var timer = setInterval(function() {
                i++;
                number.innerHTML = i;
                if (i == 404) {
                    clearInterval(timer);
                }
            }, 3);
        }
    </script>
</body>

</html>