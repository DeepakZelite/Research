<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forbidden</title>

    {!! HTML::style('assets/css/bootstrap.min.css') !!}
    {!! HTML::style('assets/css/font-awesome.min.css') !!}

    <style>
        body { padding-top: 100px; }
        h1 { font-size: 50px; margin-top: 0; }
        .icon {
            font-size: 80px;
        }

        @media (max-width: 768px) {
            body { padding-top: 50px; }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="row">
        <div class="col-md-6 col-md-push-3">
            <div class="text-center">
                <div class="icon">
                    <i class="fa fa-lock"></i>
                </div>
                <h1>Forbidden!</h1>
                <br />
                <p>You don't have permission to access this page.</p>
            </div>
        </div>
    </div>

</div>
<script>
window.location.hash="no-back-button";
window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
window.onhashchange=function(){window.location.hash="no-back-button";}
</script>
</body>
</html>