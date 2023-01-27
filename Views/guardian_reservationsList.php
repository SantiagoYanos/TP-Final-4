<?php require_once(ROOT . "/Utils/selectSize.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CSS files-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../Views/css/guardian_reservationsList.css" rel="stylesheet">

    <!-- JS files -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script type="text/javascript" src="../Views/js/alertMessage.js"></script>
    <script type="text/javascript" src="../Views/js/datepicker_manager.js"></script>
    <script type="text/javascript" src="../Views/js/datepickerCreator.js"></script>

    <title>My Reservations</title>
</head>

<body class="ms-2 me-2">

    <div class="row w-100 mt-3 ms-1">

        <div class="col col-2">

            <form <?php echo FRONT_ROOT . "Guardian/ViewReservationsGuardian" ?> method="post">
                <b><label for="state" class="form-label">State filter</label></b>
                <select class="form-select" aria-label="registration_filter" name="state">
                    <option selected>*</option>
                    <option value="Pending">Pending</option>
                    <option value="Payment pending">Payment pending</option>
                    <option value="Paid">Paid</option>
                </select>

                <input class="btn btn-primary mt-3" type="submit" value="Filter">
            </form>

        </div>

    </div>


    <table class="table table-striped table-bordered mt-3 mb-1">

        <thead>
            <th>Reservation Number</th>
            <th>Owner</th>
            <th>Price</th>
            <th>Pets</th>
            <th>Dates</th>
            <th>State</th>
            <th>Action</th>
            <th>Chat</th>
        </thead>



        <tbody>
            <?php
            $idCont = 0;

            foreach ($reservations as $reservation) {
            ?>
                <tr>

                    <!-- Se muestra la ID de la reserva !-->

                    <td><?php echo $reservation->GetId() ?></td>

                    <!-- HACER UN FORM PARA NO MOSTRAR LA ID AL AIRE | O ENCRIPTAR LA ID -->

                    <td> <a href=<?php echo  FRONT_ROOT . "Guardian/ViewOwnerProfile?id=" . $reservation->GetOwner_id() ?>><button class="btn btn-primary mt-2">Owner Profile</button></a> </td>
                    <td>$<?php echo $reservation->getPrice() ?></td>

                    <!-- Se usa la id de la reserva !-->

                    <td>
                        <a class="btn btn-warning" data-bs-toggle="collapse" href="#pets-<?php echo $reservation->getId() ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Show Pets
                        </a>
                    </td>

                    <!----------------CALENDARIO--------------------->
                    <td>

                        <div class="container align-items-end">
                            <div>
                                <div>
                                    <section class="container">

                                        <div class="input-group date mb-3" id="<?php echo $idCont ?>">
                                            <input name="reservation_dates" type="text" class="form-control" hidden>
                                            <span class="input-group-append">
                                                <span class="input-group-text bg-white">
                                                    <i class="fa fa-calendar pt-1 pb-1"></i>
                                                </span>
                                            </span>
                                        </div>

                                    </section>

                                    <!-- Meterlo en una función (o un a archivo calendario.js) - HECHO -->

                                    <?php $reservationDates =  "['" . join("','", $reservation->getDates()) . "']"; ?>

                                    <script>
                                        crearDatepicker(<?php echo $idCont ?>, <?php echo $reservationDates ?>, null)
                                    </script>

                                </div>
                            </div>
                        </div>

                    </td>
                    <!----------------CALENDARIO--------------------->

                    <td><?php echo $reservation->getState() ?> </td>

                    <td>
                        <?php
                        switch ($reservation->getState()) {

                                //No usar las ID's de las reservas directamente (En ninguno de los 3 casos)

                            case "Pending" ?>
                            <form action="<?php echo  FRONT_ROOT . "Reservation/acceptReservation" ?> " method="post">
                                <button class="btn btn-success" type="submit"> Accept </button> <input type="hidden" name="reservation_id" value="<?php echo $reservation->getId() ?>"></input>
                            </form>

                            <form action="<?php echo  FRONT_ROOT . "Reservation/rejectReservation" ?> " method="post">
                                <button class="btn btn-danger mt-2" type="submit"> Reject </button>
                                <input type="hidden" name="reservation_id" value="<?php echo $reservation->getId() ?>"></input>
                            </form>

                            <?php break; ?>

                        <?php
                            case "Paid":
                        ?><form action="<?php echo  FRONT_ROOT . "Payment/ShowPayment" ?> " method="post">
                                <button class="btn viewPaymentButton" type="submit"> View payment </button>
                                <input type="hidden" name="reservation_id" value="<?php echo $reservation->getId() ?>"></input>
                            </form>
                            <?php break;
                            ?>

                    <?php } ?>
                    </td>
                    <td>
                        <form action="<?php echo  FRONT_ROOT . "Chat/ShowChat" ?> " method="post">
                            <button class="btn viewChatButton" type="submit"> View Chat </button> <input type="hidden" name="idReceiver" value="<?php echo $reservation->getOwner_id() ?>"></input>
                        </form>
                    </td>

                </tr>

                <!-- No usar las ID's de las reservas directamente (de vuelta) -->

                <tr class="collapse" id="pets-<?php echo $reservation->getId() ?>">
                    <td colspan="8">
                        <table class="table table-bordered">

                            <thead>
                                <th>Reservation Pets</th>
                            </thead>

                            <tbody>

                                <?php foreach ($reservation->getPets() as $pet) {
                                ?>

                                    <!-- No usar la id de pets -->

                                    <tr>
                                        <td><img src="<?php echo "../" . IMG_PATH .  $pet->getId() . "/" . $pet->getPet_img(); ?> " alt="pet_photo" height="100" width="100"> </td>
                                        <td><?php echo $pet->getName() ?> </td>
                                        <td><?php echo $pet->getBreed() ?> </td>
                                        <td><?php echo ucfirst($pet->getType()) ?> </td>
                                        <td>

                                            <!-- Arreglar switch con un utils Size - HECHO -->

                                            <!-- Big | Medium | Small | Undefined -->

                                            <?php ShowValuePetSize($pet->getSize()) ?>

                                        </td>
                                        <td><img src="<?php echo "../" . IMG_PATH .  $pet->getId() . "/" . $pet->getVaccination_plan(); ?> " alt="vac note" height="100" width="100"></td>
                                        <td><?php echo $pet->getObservation() ?> </td>
                                        <!--<td> <iframe width="786" height="442" src="https://www.youtube.com/embed/A6dhKpvhNKY?autoplay=1&controls=0&" </iframe> </td>-->
                                        <td> <a class="btn btn-primary" href=" <?php echo $pet->getPet_video();   ?>" target="_blank" alt="pet video"> Video </a> </td>
                    </td>
                <?php
                                    $idCont++;
                                }
                ?>
                </tr>

        </tbody>


    </table>
    </td>
    </tr>

<?php } ?>
</tbody>

</table>

<a href=<?php echo FRONT_ROOT . "Guardian/HomeGuardian" ?>><button class="btn btn-dark mt-3">Back</button></a>

<!-- Juntar el alert con el archivo alertMessage - HECHO -->

<script>
    alertMessage(<?php echo $alert; ?>)
</script>

<!-- Chequear el funcionamiento de esto -->

<script>
    const availableDatesJson = '<?php echo $availableDatesJson ?>'

    InitializeAvailableDates(availableDatesJson);
</script>

</body>

</html>