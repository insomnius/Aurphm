<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aurphm - by Insomnius</title>
    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <style>
    
    body
    {
        background-color: #3ABEFF;
    }

    hr
    {
        color: #81D5FF;
        border: solid 1px #81D5FF;
    }

    textarea
    {
        resize: none;
        height: 200px;
    }

    .container
    {
        background-color: white;
    }

    </style>
</head>
<body>
    <div class='container'>
        
        <div class='row'>
            <div class='col-md-12'>
                <br>
                <h4 class='center'>Aurelia Pseudo Hashing Method</h4>
                <hr>
                <p>
                    Aurelia pseudo hashing method is my experimental function to hash password with HMAC (Hash-based message authentication code), PBKDF2 (Password-Based Key Derivation Function 2) and Pseudo Random Bytes.
                </p>
                <hr>
                <h5>Generating Hash</h5>
                <div class='row'>
                    
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <label for='credential-1'>Credential</label>
                            <input type='text' id='credential-1' class='form-control' placeholder='Credential...'>
                        </div>
                        <div class='form-group'>
                            <label for='password-1'>Password</label>
                            <input type='password' id='password-1' class='form-control' placeholder='Password...'>
                        </div>

                        <p>Password Value: <span id='password-1-val'></span></p>

                        <div class='form-group'>
                            <button id='password-submit-1' class='btn btn-primary'>Submit</buton>
                        </div>
                    </div>

                    <div class='col-md-8'>
                        <div class='form-group'>
                            <label for='gen-password-1'>Generated Hash</label>
                            <textarea class='form-control' id='gen-password-1'></textarea>
                        </div>
                        <p>Password length: <span id='gen-password-1-length'></span></p>
                    </div>
                </div>
            </div>
        </div>

        <br>

    </div>
</body>
<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<!-- Bootstrap Javascript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

<script>
$(document).ready(function()
{
    // autosize($('textarea'));

    $("#password-1").on("input", function()
    {
        $("#password-1-val").html($(this).val());
    });

    $("#password-submit-1").click(function()
    {
        var credential  = $("#credential-1").val();
        var password    = $("#password-1").val();

        jQuery.ajax({
            url: "/tests/submit1.php",
            method: "POST",
            data: {credential : credential, password : password},
            success: function(e)
            {
                $("#gen-password-1").val(e);
                $("#gen-password-1-length").html(e.length)
            }
        });

    });

});
</script>
</html>