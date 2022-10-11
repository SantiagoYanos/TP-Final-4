<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <div>
        <h1>Owner's Home</h1>
    </div>

    <div>
        <form action="<?php echo FRONT_ROOT . "Pet/PetList" ?>" method="post">
            <button type="submit">View Pets</button></br>
        </form>
    </div>
    
    <div>
        <form action="..." method="post">
            <button type="submit">Visualize Guardians</button></br>
        </form>
    </div>

    <div>
        <form action="..." method="post">
            <button type="submit">See Reservations</button>
        </form>
    </div>

    </br></br>

    <div>
        <h2>Owner's Information</h2>
    </div>

    <table> 
        <style>
            table, th, td {
            border:1px solid black;
            }
        </style>
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
                <th>Phone</th>
                <td><?php echo $user->getPhone() ?></td>
            </tr>

            <tr>
                <th>Password</th>
                <<td>********</td>
            </tr>

            <tr>
                <th>Birth Date</th>
                <td><?php echo $user->getBirth_date() ?></td>
            </tr>

        </tbody>
    </table>
    
    <div>
        <button type="">Edit</button>
    </div>

    </br></br>     

    <div>
        <button type="">Log Out</button>
    </div>
</body>
</html>