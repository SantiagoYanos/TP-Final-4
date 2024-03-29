<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\Views\css\utils.css">
    <link rel="stylesheet" href="../Views/css/login.css">

    <script type="text/javascript" src="../Views/js/alertMessage.js"></script>

    <title>Login</title>
</head>

<a href=<?php echo FRONT_ROOT . "Auth/ShowChooseSide" ?>></a>

<body>

    <div class="top-space"></div>

    <div class="center">
        <h1>PET HERO</h1>
        <h2>WELCOME</h2>
        <form action="<?php echo FRONT_ROOT . "Auth/Login" ?>" method="post">

            <!-- Formulario  login-->
            <div class="control-group">

                <input type="email" name="email" placeholder="Email">
            </div>

            <div class="control-group">

                <input type="password" name="password" placeholder="Password">
            </div>



            <button type="submit">Log in</button>

        </form>

        <p>¿Aún no tiene una cuenta? <a href=<?php echo FRONT_ROOT . "Auth/ShowChooseSide" ?>>Regístrese aquí</a></p>

    </div>

    <script>
        alertMessage("<?php echo $alert; ?>")
    </script>


</body>


</html>