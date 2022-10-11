<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/dec9278e05.js" crossorigin="anonymous"></script>
    <title>Guardian Home</title>
</head>
<body>
    
    <h1>Guardian's home</h1> <i class="fa fa-house"></i>

    <h2>Reputation</h2>

    <div class="container">

   
    <b>0 stars</b>
    <b class="float-end">5 stars</b>

    <div class="progress mb-3">
        <div class="progress-bar" style="width:<?php echo (($user->getReputation() *100)/5) ?>%"></div>
    </div>

    <div>
        

        <table class="table table-striped table-bordered">
            <tr>
                <th >Available Dates</th>
                <th>action</th>
                
            </tr>
            <tr>
            <td >monday  </td>
            <td name="monday">  <input id="preferencemonday " type="checkbox" name="monday" ></td>
            </tr>
            <tr>
            <td >tuesday  </td>
            <td name="tuesday">  <input id="preferencetuesday " type="checkbox" name="tuesday" ></td>
            </tr>

            <tr>
            <td>wednesday </td>
            <td name="wednesday"><input id="preferencewednesday " type="checkbox" name="wednesday" ></td>
            </tr>

            <tr>
            <td >thursday  </td>
            <td name="thursday">  <input id="preferencethursday " type="checkbox" name="thursday" ></td>
            </tr>

            <tr>
                <td>friday  </td>
                <td name="friday">  <input id="preferencefriday " type="checkbox" name="friday" ></td>
            </tr>

            <tr>
            <td>saturday </td>
            <td name="saturday"><input id="preferencesaturday " type="checkbox" name="saturday" ></td>
            </tr>

            <tr>
            <td >sunday  </td>
            <td name="sunday">  <input id="preferencesunday " type="checkbox" name="sunday" ></td>
            </tr>

        </table>

        <button>Check Petitions</button>

        <button class="submit">save changes</button>

    </div>

    <div class="container align-items-end">

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
                    <th>Phone</th>
                    <td><?php echo $user->getPhone() ?></td>
                </tr>

                <tr>
                    <th>Password</th>
                    <<td>********</td>
                </tr>

                <tr>
                    <th>Pet size reference</th>
                    <td><?php echo $user->getPrefered_size() ?></td>
                </tr>

                <tr>
                    <th>Birth Date</th>
                    <td><?php echo $user->getBirth_date() ?></td>
                </tr>
                
            </tbody>
        </table>

        <button class="float-end">Edit</button>

    </div>

    <button>Log out</button>

</body>
</html>