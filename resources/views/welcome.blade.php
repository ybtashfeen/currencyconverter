<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Currency Exchange</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>

    <style>

    </style>
</head>
<body class="">
<div id="container">
    <div class="row">
        <div class="col-md-4">
            <div class="form_main">
                <h4 class="heading"><strong>Quick </strong> Contact <span></span></h4>
                <form id="exchange-form" name="exchange-form" method="get">
                    <div class="col-md-12">
                        <div class="row">
                            <label class="title">From</label>
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
                            <input type="text" name="amount" id="name" autocomplete="false" required="" placeholder="Enter Amount" value="" class="txt">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <input id="submit" type="submit" value="Exchange" class="txt2">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">

    (function($){
        $("form").on("submit", function(e){
            e.preventDefault();
            var form = $(e.target);
            $.get( '/api/currency', form.serialize(), function(res){
                console.log(res);
            });
        });
    })(jQuery);
</script>
</body>
</html>
