<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/dec9278e05.js" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/bootstrap-multiselect.css">
    <script data-main="dist/js/" src="js/require.min.js"></script>

    <script src="../Utils/petlist_function.js"></script>
    <script type="text/javascript" src="../utils/multiselect_dropdown.js"></script>
    <style type="text/css">
        select {
            width: 30em;
            height: 30em;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

        <!-- Calcular la reputación desde el servidor -->

        <div class="progress mb-3">
            <div class="progress-bar" style="width:<?php echo (($guardian->getType_Data()->getReputation() * 100) / 5) ?>%"></div>
        </div>

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
            <form action=<?php echo FRONT_ROOT . "Review/ShowReviews" ?> method=GET style="display:inline">
                <input type="hidden" name="id" value="<?php echo $guardian->getId() ?>">
                <button class="btn btn-dark mt-2">View Reviews</button>
            </form>

            <a href=<?php echo FRONT_ROOT . "Chat/ShowChat?id=" . $guardian->getId(); ?> type="button" class="btn btn-primary mt-2" style="background-color: #033793; color: white">View Chat</a>

        </span>

        <br>

        <a href=<?php echo FRONT_ROOT . "Owner/SearchGuardian" ?>><button class="btn btn-dark mt-2">Back</button></a>

        <hr>

        <h3>Make Reservation</h3>

        <!----------------------------------------------------------------------------------------------------------------->

        <!-----------SELECCION DE PETS------------------------------------------------------------------------------------->

        <!-- Está todo bien?? -->

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

                        // Chequear ese input 

                        foreach ($PetList as $pet) {
                            echo '<input type="checkbox" name="pets_ids[]" value=' . $pet->getId() . " > " . "<b class='ms-2'>" . $pet->getName() . "</b>" . "</option> <br>";
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

            <input type="hidden" name="guardian_id" value="<?php echo $guardian->getID() ?>"></input>

            <button class="btn btn-primary mb-3" type="submit">Make Reservation </button></br>

        </form>

        <!-- AlertMessage - HECHO -->

        <script>
            alertMessage(<?php echo $alert; ?>)
        </script>

        <script type="text/javascript" src="../Views/js/datepicker_manager.js"></script>


        <!-- Se puede hacer mejor? -->

        <script>
            const availableDatesJson = '<?php echo $availableDatesJson ?>'

            InitializeAvailableDates(availableDatesJson);
        </script>

</body>

</html>