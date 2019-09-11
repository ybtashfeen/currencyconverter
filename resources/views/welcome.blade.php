<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Currency Exchange</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="css/app.css" rel="stylesheet">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <style>

    </style>
</head>
<body class="">
<div id="container">
    <div class="row">
        <div class="col-md-12   ">
            <div class="form_main">
                <h4 class="heading"><strong>Currency </strong> Exchange<span></span></h4>
                <form id="exchange-form" name="exchange-form" method="get">
                    <div class="col-md-12">
                        <div class="row">
                            <label class="pad-10">From</label>
                            <select id="from_currency" name="from_currency" required class="txt">
                                <option>GBP</option>
                                <option>USD</option>
                                <option>EUR</option>
                                <option>AUD</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <label class="title">To</label>
                            <select id="to_currency" name="to_currency">
                                <option>GBP</option>
                                <option>USD</option>
                                <option>EUR</option>
                                <option>AUD</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <label class="title">Amount</label>
                            <input type="text" name="amount" id="name" required="" placeholder="Enter Amount"
                                   class="text">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <label class="title">Converted</label>
                            <div id="converted" class="ml-3"></div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="row">
                            <input id="submit" type="submit" value="Exchange" class="submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">

    (function ($) {
        $("form").on("submit", function (e) {
            e.preventDefault();
            var form = $(e.target);
            $.get('/api/currency', form.serialize(), function (res) {
                if (res.type === 'error') {
                    $('#converted').removeClass('alert-success').addClass('alert-danger').html(res.message);
                } else {
                    if (res.message === -1) {
                        $('#converted').removeClass('alert-success').addClass('alert-danger').html('Problem with the service');
                    } else {
                        $('#converted').removeClass('alert-danger').addClass('alert-success').html(res.message);
                    }
                }
            });
        });
    })(jQuery);
</script>
</body>
</html>
