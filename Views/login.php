<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h1>PET HERO</h1>
    <div>
        <form action="<?php echo FRONT_ROOT . "Auth/Login" ?>" method="post">
            <!-- formulario  login-->
            <div class="control-group">

                <input type="email" name="email" placeholder="Email">
            </div>

            <div class="control-group">

                <input type="password" name="password" placeholder="Password">
            </div>

            <h2>WELCOME</h2>


            <button type="submit">Log in</button>

            <button type="text">Register</button>

        </form>



    </div>
</body>

</html>
?>