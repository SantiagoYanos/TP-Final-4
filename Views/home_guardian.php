<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/dec9278e05.js" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script type="text/javascript" src="../Views/js/alertMessage.js"></script>
    <script type="text/javascript" src="../Views/js/datepickerCreator.js"></script>

    <title>Guardian Home</title>
</head>

<body class="ms-2 me-2">

    <h1>Guardian's home</h1> <i class="fa fa-house"></i>


    <h2>Reputation</h2>

    <div class="container">

        <b>0 Stars</b>
        <b class="float-end">5 Stars</b>

        <!-- Traer la reputación transformada desde el servidor - HECHO -->

        <div class="progress mb-3">
            <div class="progress-bar" style="width:<?php echo $ratingPercent ?>%"></div>
        </div>

        <b>
            <!-- Mostrar el porcentaje de reviews a escala de 100% y la cantidad. Ex. 87% (15 Reviews) -->
            <?php echo "(" . $ratingPercent . ") " . $reviewsAmount . " Reviews" ?>
        </b>

        <div>

            <section class="container">
                <h4 class="pt-4 pb-1">Available Dates</h4>
                <form action=<?php echo FRONT_ROOT . "Guardian/updateAvDates"
                                ?> method="post">
                    <div class="input-group date mb-3" id="datepicker">
                        <input name="stringDates" type="text" class="form-control" hidden>
                        <span class="input-group-append">
                            <span class="input-group-text bg-white">
                                <i class="fa fa-calendar pt-1 pb-1"></i>
                            </span>
                        </span>
                    </div>

                    <button class="btn btn-primary" type="submit">Save Dates Changes</button>

                </form>
            </section>

            <!-- Funcion calendario... - HECHO -->

            <?php $dates =  "['" . join("','", $user->getType_data()->getAvailable_date()) . "']"; ?>

            <script>
                crearDatepicker("datepicker", <?php echo $dates; ?>, 'date("Y-m-d")');
            </script>

        </div>

        <br>

        <span>
            <a href=<?php echo FRONT_ROOT . "Guardian/ViewReservations" ?>><button class="btn pl-1" style="background-color: purple; color: white">Visualize Reservations</button></a>

            <form action=<?php echo FRONT_ROOT . "Review/ShowReviews" ?> method=GET style="display:inline">
                <input type="hidden" name="id" value="<?php echo $user->getId() ?>">
                <button class="btn btn-warning ms-2">View Reviews</button>
            </form>
        </span>

        <div class="container align-items-end">

            <table class="table table-striped table-bordered mt-3 mb-1">

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
                        <th>Cuil</th>
                        <td><?php echo $user->getType_Data()->getCuil() ?></td>
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
                        <td><?php echo ucwords($user->getType_Data()->getPreferred_size()) ?></td>
                    </tr>

                    <tr>
                        <th>Cat Size Peference</th>
                        <td><?php echo ucwords($user->getType_Data()->GetPreferred_size_cat()) ?></td>
                    </tr>

                    <tr>
                        <th>Birth Date</th>
                        <td><?php echo $user->getBirth_date() ?></td>
                    </tr>

                    <tr>
                        <th>Price</th>
                        <td><?php if ($user->getType_Data()->getPrice() == NULL) {
                                echo "UNASSIGNED";
                            } else {
                                echo "$" . $user->getType_Data()->getPrice();
                            }
                            ?></td>
                    </tr>

                </tbody>

            </table>

            <?php if ($user->getType_Data()->getPrice() == NULL) {
                echo "<b>(WARNING: If price is not setted, you will not be able to get Reservations!)</b>";
            }
            ?>

            <a href=<?php echo FRONT_ROOT . "Guardian/ShowEdit" ?>><button class="btn btn-info border-dark float-end mt-2">Edit</button></a>

        </div>

        <form action=<?php echo FRONT_ROOT . "Auth/logOut" ?> method="post">
            <button type="submit" class="btn btn-dark mt-2" onclick="alertMessage('Goodbye!')">Logout</button>

            <!-- Only alertMessage - HECHO -->

        </form>

        <script>
            alertMessage(<?php echo $alert; ?>)
        </script>

</body>

</html>