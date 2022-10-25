<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\Views\css\styleRegisterGuardian.css">
    <!--<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>-->
    <!--<link href="https://fonts.googleapis.com/css2?family=Nabla&display=swap" rel="stylesheet">-->
    <title>Guardian Register</title>
</head>

<body>
    <div class="center">
        <h1>Guardian Register</h1>
        <h2>Add your info: </h2><br>

        <form action="<?php echo FRONT_ROOT . "Auth/RegisterGuardian" ?>" method="post">
            <div class="txt_field">
                <input type="text" name="name" required></br>
                <label for="name">Name: </label>
            </div>
            <div class="txt_field">
                <input type="text" name="last_name" required></br>
                <label for="">Last Name: </label>
            </div>
            <div class="txt_field">
                <input type="text" name="cuil" required></br>
                <label for="cuil">Cuil: </label>
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

            <div>
                <label for="preferred_size">Pet Size Preference: </label>
                <select name="preferred_size" id="preferred_size" required>
                    <option value="small">Small</option>
                    <option value="medium">Medium</option>
                    <option value="big">Big</option>
                </select></br>
            </div>

            <div class="txt_field">
                <input type="date" name="birth_date"></br>
                <label for="birthdate">Birthdate: </label>
            </div>

            <!--<input type="checkbox" name="terms_conditions" value="terms_conditions" required> </input>-->
            <!--<a href="./images/rick-roll.gif">I agree to the terms and conditions</a></br>-->

            <button style="margin-bottom:15px" type="submit">Register</button>
        </form>
    </div>
</body>

</html>