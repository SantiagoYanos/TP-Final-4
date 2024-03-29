<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CSS files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- JS files -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script type="text/javascript" src="../Views/js/alertMessage.js"></script>

    <title>Owner Edit</title>
</head>

<body class="ms-2 me-2">

    <h1>Owner Edit</h1> <i class="fa fa-house"></i>

    <div class="container">

        <div class="container align-items-end">

            <form action=<?php echo FRONT_ROOT . "Owner/Edit" ?> method="post">

                <table class="table table-striped table-bordered mt-3">

                    <tbody>

                        <tr>
                            <th>Name</th>
                            <td><input type="text" id="name" name="name" value="<?php echo $user->getName() ?>" required></td>
                        </tr>

                        <tr>
                            <th>Last Name</th>
                            <td><input type="text" id="last_name" name="last_name" value="<?php echo $user->getLast_name() ?>" required></td>
                        </tr>

                        <tr>
                            <th>Adress</th>
                            <td><input type="text" id="adress" name="adress" value="<?php echo $user->getAdress() ?>" required></td>
                        </tr>

                        <tr>
                            <th>DNI</th>
                            <td><input type="text" id="dni" name="dni" value="<?php echo $user->getType_Data()->getDni() ?>" required></td>
                        </tr>

                        <tr>
                            <th>Phone</th>
                            <td><input type="text" id="phone" name="phone" value="<?php echo $user->getPhone() ?>" required></td>
                        </tr>

                        <tr>
                            <th>Password</th>
                            <td>********</td>
                        </tr>

                        <tr>
                            <th>Birth Date</th>
                            <td>
                                <div>
                                    <label for="birth_date">Birthdate: </label>
                                    <input type="date" name="birth_date" max="<?php echo date("Y-m-d") ?>" required></br>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>

                <button class="btn btn-info border-dark" type="submit">Edit</button>

            </form>


            <a href=<?php echo FRONT_ROOT . "Owner/HomeOwner" ?>><button class="btn btn-dark mt-3">Back</button></a>

        </div>

        <script>
            alertMessage("<?php echo $alert; ?>")
        </script>

</body>

</html>