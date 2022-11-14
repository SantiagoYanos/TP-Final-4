<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/dec9278e05.js" crossorigin="anonymous"></script>
    <title>Home</title>
</head>

<body>
    <div>
        <h1><?php echo $user->getName()?>'s Home</h1>
    </div>

    <div>
        <form action="<?php echo FRONT_ROOT . "Pet/PetList" ?>" method="post">
            <button type="submit">View Pets</button></br>
        </form>
    </div>

    <div>
        <form action="<?php echo FRONT_ROOT . "Owner/SearchGuardian" ?>" method="post">
            <button type="submit">Visualize Guardians</button></br>
        </form>
    </div>

    <div>
        <form action="<?php echo FRONT_ROOT . "Owner/ViewReservationsOwner" ?>"  method="post">
            <button type="submit">See Reservations</button>
        </form>
    </div>

    </br></br>

    <div>
        <h2>Owner's Information</h2>
    </div>

    <div>
        <table class="table table-striped table-bordered mt-2">

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
        <a href=<?php echo FRONT_ROOT . "Owner/ShowEdit" ?>><button class="float-end mt-2">Edit</button></a>
    </div>

    <form action=<?php echo FRONT_ROOT . "Auth/logOut" ?> method="post">
        <button type="submit" onclick="alertMessage()">Logout</button>

        <script>
            function alertMessage() {
                alert("Goodbye!");
            }
        </script>

    </form>
</body>

</html>