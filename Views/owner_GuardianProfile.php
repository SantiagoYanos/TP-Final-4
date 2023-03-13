<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <!-- Otro Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- CSS Files-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../Views/css/owner_GuardianProfile.css">

    <!-- JS Files -->
    <link rel="stylesheet" href="css/bootstrap-multiselect.css">
    <script data-main="dist/js/" src="js/require.min.js"></script>

    <script src="../Utils/petlist_function.js"></script>
    <script type="text/javascript" src="../utils/multiselect_dropdown.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script type="text/javascript" src="../Views/js/alertMessage.js"></script>
    <script type="text/javascript" src="../Views/js/datepickerCreator.js"></script>

    <title>Guardian Profile</title>
</head>

<body class="ms-2 me-2">

    <h1><?php echo $guardian->getName() ?>'s profile</h1> <i class="fa fa-house"></i>


    <h2>Reputation</h2>

    <div class="container">

        <b>0 Stars</b>
        <b class="float-end">5 Stars</b>

        <!-- Traer y calcular la reputación desde el servidor - HECHO -->

        <div class="progress mb-3">
            <div class="progress-bar" style="width:<?php echo $ratingPercent ?>%"></div>
        </div>

        <b>
            <!-- Mostrar el porcentaje de reviews a escala de 100% y la cantidad. Ex. 87% (15 Reviews) - HECHO -->
            <?php echo "(" . number_format((float)$ratingPercent, 1, ',', '') . "%) " . $reviewsAmount . " Reviews" ?>
        </b>

        <br>

        <div class="container align-items-end">

            <table class="table table-striped table-bordered mt-3 mb-1">

                <tbody>

                    <tr>
                        <th>Name</th>
                        <td><?php echo $guardian->getName() ?></td>
                    </tr>

                    <tr>
                        <th>Last Name</th>
                        <td><?php echo $guardian->getLast_name() ?></td>
                    </tr>

                    <tr>
                        <th>Adress</th>
                        <td><?php echo $guardian->getAdress() ?></td>
                    </tr>

                    <tr>
                        <th>Cuil</th>
                        <td><?php echo $guardian->getType_Data()->getCuil() ?></td>
                    </tr>

                    <tr>
                        <th>Phone</th>
                        <td><?php echo $guardian->getPhone() ?></td>
                    </tr>

                    <tr>
                        <th>Dog Size Preference</th>
                        <td><?php echo ucwords($guardian->getType_Data()->getPreferred_size()) ?></td>
                    </tr>

                    <tr>
                        <th>Cat Size Peference</th>
                        <td><?php echo ucwords($guardian->getType_Data()->GetPreferred_size_cat()) ?></td>
                    </tr>

                    <tr>
                        <th>Birth Date</th>
                        <td><?php echo $guardian->getBirth_date() ?></td>
                    </tr>

                    <tr>
                        <th>Price</th>
                        <td><?php if ($guardian->getType_Data()->getPrice() == NULL) {
                                echo "UNASSIGNED";
                            } else {
                                echo "$" . $guardian->getType_Data()->getPrice();
                            }
                            ?></td>
                    </tr>

                </tbody>

            </table>

        </div>

        <span>
            <!-- ID a la vista - HECHO -->

            <form action=<?php echo FRONT_ROOT . "Review/ShowReviews" ?> method=POST style="display:inline">
                <input type="hidden" name="guardianId" value="<?php echo encrypt($guardian->getId()); ?>">
                <button class="btn btn-warning mt-3">View Reviews</button>
            </form>

            <!-- ID a la vista - HECHO -->

            <?php if ($reservationInCommon == true) { ?>

                <form action=<?php echo FRONT_ROOT . "Chat/ShowChat" ?> method=POST style="display:inline">
                    <input type="hidden" name="idReceiver" value=<?php echo encrypt($guardian->getId()); ?>></input>
                    <input type="submit" class="btn btn-primary mt-3 viewChatButton" value="View Chat">
                </form>

            <?php } ?>

        </span>

        <br>

        <a href="<?php echo $backLink ?>"><button class="btn btn-dark mt-3">Back</button></a>

        <hr>

        <h3>Make Reservation</h3>

        <!----------------------------------------------------------------------------------------------------------------->

        <!-----------SELECCION DE PETS------------------------------------------------------------------------------------->

        <script>
            require(['bootstrap-multiselect'], function(purchase) {
                $('#pets_ids').multiselect();
            });
        </script>

        <form action=<?php echo FRONT_ROOT . "Reservation/MakeReservation" ?> method="post">
            <div class="container align-items-end">
                <div>
                    <label for="pets_ids">Select Your Pets: </label>
                    <div class="checkboxlist" id="skills">
                        <?php
                        $cont = 0;

                        // Chequear ese input // ID a la vista

                        foreach ($PetList as $pet) {
                            echo '<input type="checkbox" name="pets_ids[' . $cont . ']" value=' . encrypt($pet->getId()) . " > " . "<b class='ms-2'>" . $pet->getName() . "</b>" . "</option> <br>";
                            $cont++;
                        }
                        echo "<br>"
                        ?>
                    </div>
                </div>
            </div>

            <!----------------------------------------------------------------------------------------------------------------->


            <!-----------SELECCION DE FECHAS----------------------------------------------------------------------------------->

            <div class="container align-items-end">
                <div>

                    <label for="dates">Select Dates: </label>

                    <div>
                        <section class="container">

                            <div class="input-group date mb-3" id="datepicker">
                                <input name="reservation_dates" type="text" class="form-control" hidden>
                                <span class="input-group-append">
                                    <span class="input-group-text bg-white">
                                        <i class="fa fa-calendar pt-1 pb-1"></i>
                                    </span>
                                </span>
                            </div>

                        </section>

                        <!-- Funcion calendario? - HECHO -->

                        <script>
                            crearDatepicker("datepicker", null, 'date("Y-m-d")');
                        </script>

                    </div>
                </div>
            </div>

            <!-- GuardianID a la vista -->

            <input type="hidden" name="guardian_id" value="<?php echo encrypt($guardian->getID()); ?>"></input>

            <button class="btn btn-primary mb-3" type="submit">Make Reservation </button></br>

        </form>

        <script type="text/javascript" src="../Views/js/datepicker_manager.js"></script>


        <!-- Mirar funcion availableDates - HECHO -->

        <script>
            const availableDatesJson = '<?php echo $availableDatesJson ?>'

            InitializeAvailableDates(availableDatesJson);
        </script>

        <!-- AlertMessage - HECHO -->

        <script>
            alertMessage(<?php echo $alert; ?>)
        </script>

</body>

</html>