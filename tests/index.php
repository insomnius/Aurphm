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
                <p>
                    The aim for this library is to ensure that the user password randomly generated everytime user do Authentication and we can still Authenticate that with simple way. The basic structure of my hash result is <b>AURHPHM_SALT.USERUNIQUE.UC_SIGNATURE</b>.
                </p>
                <hr>
                <h5>Generating Hash</h5>
                <div class='row'>
                    <div class='col-md-12'>
                    <p>
                        Credential must be your key to hash the password. The hash result will change overtime, but you can still authenticate the password with simple way.
                    </p>
                    </div>
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

                <hr>
                <h5>Advance Option</h5>
                <p>You can set numbers of iteration, length of the hashed value and prefix. Hash length has to be higher than 256 characters. You can even change the algorithm, as a default i use SHA256 for salt and SHA512 for both of user unique and hash signature.</p>
                <p>Password algorithm that u use must be supported by your version of PHP. If you dont know what algorithm do you have, please click the button bellow this section.</p>
                <div class='row'>
                    
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <label for='credential-2'>Credential</label>
                            <input type='text' id='credential-2' class='form-control' placeholder='Credential...'>
                        </div>
                        <div class='form-group'>
                            <label for='password-2'>Password</label>
                            <input type='password' id='password-2' class='form-control' placeholder='Password...'>
                        </div>
                        <p>Password Value: <span id='password-2-val'></span></p>
                        <div class='form-group'>
                            <label for='iteration-2'>Signature Iteration</label>
                            <input type='number' id='iteration-2' class='form-control' placeholder='Iteration...' value='16'>
                        </div>
                        <div class='form-group'>
                            <label for='signature-length-2'>Signature Length</label>
                            <input type='number' id='signature-length-2' class='form-control' placeholder='Length...' value='64'>
                        </div>
                        <div class='form-group'>
                            <label for='salt-algo-2'>Salt Algorithm</label>
                            <input type='text' id='salt-algo-2' class='form-control' placeholder='Salt Algorithm...' value='SHA256'>
                        </div>
                        <div class='form-group'>
                            <label for='userunique-algo-2'>User Unique Algorithm</label>
                            <input type='text' id='userunique-algo-2' class='form-control' placeholder='User Unique Algorithm...' value='SHA512'>
                        </div>
                        <div class='form-group'>
                            <label for='signature-algo-2'>Signature Algorithm</label>
                            <input type='text' id='signature-algo-2' class='form-control' placeholder='Signature Algorithm...' value='SHA512'>
                        </div>
                        <div class='form-group'>
                            <label for='prefix-2'>Prefix</label>
                            <input type='text' id='prefix-2' class='form-control' placeholder='Prefix...' value='AURPHM'>
                        </div>

                        <div class='form-group'>
                            <button id='password-submit-2' class='btn btn-primary'>Submit</buton>
                        </div>
                    </div>

                    <div class='col-md-8'>
                        <div class='form-group'>
                            <label for='gen-password-2'>Generated Hash</label>
                            <textarea class='form-control' id='gen-password-2'></textarea>
                        </div>
                        <p>Password length: <span id='gen-password-2-length'></span></p>
                    </div>
                </div>
                
                <hr>
                <h5>List of Hashing Algorithm</h5>
                <p>You can see what algorithm avalaible in your php.</p>
                <div class='row'>
                    <div class='col-md-12'>
                        <button class='btn btn-primary' id='algo-list'>Click to see the list.</button>
                        <br><br>
                        <ul id='algo-list-content'>

                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        Copyrigth &copy; insomnius, All right reserved. awc.aliana@gmail.com .
        <br><br>
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

    $("#password-2").on("input", function()
    {
        $("#password-2-val").html($(this).val());
    });

    $("#password-submit-1").click(function()
    {
        var credential  = $("#credential-1").val();
        var password    = $("#password-1").val();

        jQuery.ajax({
            url: "/submit1.php",
            method: "POST",
            data: {credential : credential, password : password},
            success: function(e)
            {
                $("#gen-password-1").val(e);
                $("#gen-password-1-length").html(e.length)
            }
        });

    });

    $("#password-submit-2").click(function()
    {
        var credential  = $("#credential-2").val();
        var password    = $("#password-2").val();
        var length      = $("#signature-length-2").val();
        var iteration   = $("#iteration-2").val();
        var prefix      = $("#prefix-2").val();
        var saltalgo        = $("#salt-algo-2").val();
        var useruniquealgo  = $("#userunique-algo-2").val();
        var signaturealgo   = $("#signature-algo-2").val();

        jQuery.ajax({
            url: "/submit2.php",
            method: "POST",
            data: {credential : credential, password : password, length : length, iteration : iteration, prefix : prefix, saltalgo : saltalgo, useruniquealgo : useruniquealgo, signaturealgo : signaturealgo},
            success: function(e)
            {
                $("#gen-password-2").val(e);
                $("#gen-password-2-length").html(e.length)
            }
        });

    });

    $("#algo-list").click(function()
    {
        jQuery.ajax({
            url: "/submit3.php",
            method: "GET",
            success: function(e)
            {
                $("#algo-list-content").html(e);
            }
        });
    });

});
</script>
</html>