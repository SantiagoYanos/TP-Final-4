<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\Views\css\styleRegisterOwner.css">
    <title>Owner Register</title>
</head>

<body>
    <div class="center">
    <h1>Owner Register</h1>
    <h2>Add your info: </h2><br>

    <form action="<?php echo FRONT_ROOT . "Auth/RegisterOwner" ?>" method="post">
        <div class="txt_field">
            <input type="text" name="name" required></br>    
            <label for="name">Name: </label>
        </div>
        <div class="txt_field">
            <input type="text" name="last_name" required></br>
            <label for="">Last Name: </label>
        </div>
        <div class="txt_field">
            <input type="text" name="dni" required></br>
            <label for="">DNI: </label>
        </div>
        <div class="txt_field">
            <input type="email" name="email" required></br>
            <label for="">Email: </label>
        </div>
        <div class="txt_field">
            <input type="password" name="password" required></br>
            <label for="">Password: </label>
        </div>
        <div class="txt_field">
            <input type="text" name="adress" required></br>
            <label for="">Adress: </label>
        </div>
        <div class="txt_field">
            <input type="phone" name="phone" required></br>
            <label for="">Phone: </label>
        </div>
        <div class="txt_field">
            <input type="date" name="birth_date" required></br>
            <label for="birthdate">Birthdate: </label>
        </div>

        <!--<input type="checkbox" name="terms_conditions" value="terms_conditions"></input>-->
        <!--<a href="/tp-final-4/images/rick-roll.gif">I agree to the terms and conditions</a></br>-->

        <button type="submit">Continue</button>
    </form>
    </div>
</body>

</html>