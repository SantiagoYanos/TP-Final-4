<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\Views\css\styleRegisterGuardian.css">

    <script type="text/javascript" src="../Views/js/alertMessage.js"></script>

    <title>Guardian Register</title>
</head>

<body>
    <div class="center">
        <h1>Guardian Register</h1>
        <h2 style="padding-top: 20px;">Add your info: </h2>

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
                <label for="preferred_size">Dog Size Preference: </label>
                <select name="preferred_size" id="preferred_size" required>
                    <option value=3>Small</option>
                    <option value=2>Medium</option>
                    <option value=1>Big</option>
                </select></br>
            </div>

            </br>

            <div>
                <label for="preferred_size_cat">Cat Size Preference: </label>
                <select name="preferred_size_cat" id="preferred_size_cat" required>
                    <option value=3>Small</option>
                    <option value=2>Medium</option>
                    <option value=1>Big</option>
                </select></br>
            </div>

            <div class="txt_field">
                <input type="date" name="birth_date" max="<?php echo date("Y-m-d") ?>"></br>
                <label for="birthdate">Birthdate: </label>
            </div>

            <button style="margin-bottom:15px" type="submit">Register</button>

        </form>

    </div>

    <script>
        alertMessage("<?php echo $alert; ?>")
    </script>

</body>

</html>