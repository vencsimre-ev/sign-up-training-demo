<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edzés regisztráció</title>
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mt-5">
                <h2 class="heading-section main-title">Edzés regisztráció</h2>
                <br>
                <img src="public/images/mountex.jpg" width=130px>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6 text-center mt-4">
                <div id="responseMessage"></div>

                <?php // if (isset($message)) echo "<p>$message</p>"; 
                ?>

                <form method="POST" action="" id="registerForm">
                    <div class="mb-3">
                        <label for="name" class="form-label"><strong>Név:</strong></label>
                        <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp">
                        <div id="nameHelp" class="form-text">Segíts hogy megjegyezzelek ;)</div>
                    </div>
                    <!-- <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div> -->
                    <button type="submit" class="btn btn-primary" id="submitBtn">Részt veszek!</button>
                </form>
            </div>
        </div>

    </div>
    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/register_v23.js"></script>
</body>

</html>