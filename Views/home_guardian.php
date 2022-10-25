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


        <b>0 Stars</b>
        <b class="float-end">5 Stars</b>

        <div class="progress mb-3">
            <div class="progress-bar" style="width:<?php echo (($user->getReputation() * 100) / 5) ?>%"></div>
        </div>

        <div>

            <!-- <form action=<?php //echo FRONT_ROOT . "Guardian/updateAvDates" 
                                ?> method="post">

                <table class="table table-striped table-bordered">

                    <tr>
                        <th>Available Dates</th>
                        <th>Select</th>

                    </tr>

                    <tr>
                        <td>Monday </td>
                        <td name="monday"> <input id="preferencemonday " type="checkbox" name="monday" <?php /*if ($user->getAvailable_date()["monday"]) {
                                                                                                            echo "checked";
                                                                                                    
                                                                                                        } */ ?>></td>
                    </tr>

                    <tr>
                        <td>Tuesday </td>
                        <td name="tuesday"> <input id="preferencetuesday " type="checkbox" name="tuesday" <?php /*if ($user->getAvailable_date()["tuesday"]) {
                                                                                                                echo "checked";
                                                                                                            } */ ?>></td>
                    </tr>

                    <tr>
                        <td>Wednesday </td>
                        <td name="wednesday"><input id="preferencewednesday " type="checkbox" name="wednesday" <?php /*if ($user->getAvailable_date()["wednesday"]) {
                                                                                                                    echo "checked";
                                                                                                                } */ ?>></td>
                    </tr>

                    <tr>
                        <td>Thursday </td>
                        <td name="thursday"> <input id="preferencethursday " type="checkbox" name="thursday" <?php /* if ($user->getAvailable_date()["thursday"]) {
                                                                                                                    echo "checked";
                                                                                                                } */ ?>></td>
                    </tr>

                    <tr>
                        <td>Friday </td>
                        <td name="friday"> <input id="preferencefriday " type="checkbox" name="friday" <?php /* if ($user->getAvailable_date()["friday"]) {
                                                                                                            echo "checked";
                                                                                                        } */ ?>></td>
                    </tr>

                    <tr>
                        <td>Saturday </td>
                        <td name="saturday"><input id="preferencesaturday " type="checkbox" name="saturday" <?php /* if ($user->getAvailable_date()["saturday"]) {
                                                                                                                echo "checked";
                                                                                                            } */ ?>></td>
                    </tr>

                    <tr>
                        <td>Sunday </td>
                        <td name="sunday"> <input id="preferencesunday " type="checkbox" name="sunday" <?php /* if ($user->getAvailable_date()["sunday"]) {
                                                                                                            echo "checked";
                                                                                                        } */ ?>></td>
                    </tr>

                </table>

                <button>Check Petitions</button>

                <button class="submit">Save Changes</button>

            </form> -->

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
                        <td>********</td>
                    </tr>

                    <tr>
                        <th>Dog Size Preference</th>
                        <td><?php echo $user->getPreferred_size() ?></td>
                    </tr>

                    <tr>
                        <th>Cat Size Peference</th>
                        <td><?php echo $user->GetPreferred_size_cat() ?></td>
                    </tr>

                    <tr>
                        <th>Birth Date</th>
                        <td><?php echo $user->getBirth_date() ?></td>
                    </tr>

                </tbody>
            </table>

            <button class="float-end">Edit</button>

        </div>

        <form action=<?php echo FRONT_ROOT . "Auth/logOut" ?> method="post">
            <button type="submit">Log out</button>

        </form>



</body>

</html>