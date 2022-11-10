<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/dec9278e05.js" crossorigin="anonymous"></script>
    <title>OwnersProfile/title>
</head>

<body>
    <div>
        <h1>Owner's profile</h1>
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
                    <td><?php echo $owner->getName() ?></td>
                </tr>

                <tr>
                    <th>Last Name</th>
                    <td><?php echo $owner->getLast_name() ?></td>
                </tr>

                <tr>
                    <th>Adress</th>
                    <td><?php echo $owner->getAdress() ?></td>
                </tr>

                <tr>
                    <th>DNI</th>
                    <td><?php echo $owner->getType_Data()->getDni() ?></td>
                </tr>

                <tr>
                    <th>Phone</th>
                    <td><?php echo $owner->getPhone() ?></td>
                </tr>

               
                <tr>
                    <th>Birth Date</th>
                    <td><?php echo $owner->getBirth_date() ?></td>
                </tr>

            </tbody>
        </table>

    </div>


    <a href=<?php echo FRONT_ROOT . "Guardian/ViewReservations" ?>><button class="mt-2">Back</button></a>

    
 
</body>

</html>