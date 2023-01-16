<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/dec9278e05.js" crossorigin="anonymous"></script>

    <script type="text/javascript" src="../Views/js/alertMessage.js"></script>

    <title>Home</title>
</head>

<body class="ms-2 me-2">
    <div>
        <h1><?php echo $user->getName() ?>'s Home</h1>
    </div>

    <div>
        <form action="<?php echo FRONT_ROOT . "Pet/PetList" ?>" method="post">
            <button class="btn btn-warning mb-2 mt-3 border-dark" type="submit">View Pets</button></br>
        </form>
    </div>

    <div>
        <form action="<?php echo FRONT_ROOT . "Owner/SearchGuardian" ?>" method="post">
            <button class="btn btn-primary mb-2 border-dark" type="submit">Visualize Guardians</button></br>
        </form>
    </div>

    <div>
        <form action="<?php echo FRONT_ROOT . "Owner/ViewReservationsOwner" ?>" method="post">
            <button class="btn mb-2 border-dark" style="background-color: purple; color: white" type="submit">See Reservations</button>
        </form>
    </div>

    </br>

    <div>
        <h2>Owner's Information</h2>
    </div>

    <div>
        <table class="table table-striped table-bordered mt-2 border-dark">

            <tbody>
                <tr>
                    <th>Name</th>
                    <td><?php echo $user->getName() ?></td>
                </tr>

                <tr>
                    <th>Last Name</th>
                    <td><?php echo $user->getLast_name() ?></td>
                </tr>

                <tr>
                    <th>Adress</th>
                    <td><?php echo $user->getAdress() ?></td>
                </tr>

                <tr>
                    <th>DNI</th>
                    <td><?php echo $user->getType_Data()->getDni() ?></td>
                </tr>

                <tr>
                    <th>Phone</th>
                    <td><?php echo $user->getPhone() ?></td>
                </tr>

                <tr>
                    <th>Password</th>
                    <td>********</td>
                </tr>

                <tr>
                    <th>Birth Date</th>
                    <td><?php echo $user->getBirth_date() ?></td>
                </tr>

            </tbody>
        </table>

    </div>

    <div>
        <a href=<?php echo FRONT_ROOT . "Owner/ShowEdit" ?>><button class="btn btn-info float-end btn-outline-dark">Edit</button></a>
    </div>

    <!-- Función alertMessage - HECHO -->

    <form action=<?php echo FRONT_ROOT . "Auth/logOut" ?> method="post">
        <button class="btn btn-dark" type="submit" onclick="alertMessage('Goodbye!')">Logout</button>

    </form>
</body>

</html>