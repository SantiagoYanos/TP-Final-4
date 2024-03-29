<?php require_once(ROOT . "/Utils/selectSize.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="../Views/css/owner_reservationsList.css">

    <!-- JS Files -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script type="text/javascript" src="../Views/js/alertMessage.js"></script>
    <script type="text/javascript" src="../Views/js/datepickerCreator.js"></script>
    <script type="text/javascript" src="../Views/js/datepicker_manager.js"></script>

    <title>My Reservations</title>
</head>

<body class="ms-2 me-2">

    <div class="row w-100 mt-3 ms-1">

        <div class="col col-2">

            <form <?php echo FRONT_ROOT . "Owner/ViewReservationsOwner" ?> method="post">
                <b><label for="state" class="form-label">State filter</label></b>
                <select class="form-select mb-3" aria-label="registration_filter" name="state">
                    <option selected>*</option>
                    <option value="Pending">Pending</option>
                    <option value="Payment pending">Payment pending</option>
                    <option value="Paid">Paid</option>
                </select>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="on" id="rejected" name="rejected" <?php echo $rejectedCheck ?>>
                    <label class="form-check-label" for="rejected">Rejected</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="on" id="canceled" name="canceled" <?php echo $canceledCheck ?>>
                    <label class="form-check-label" for="canceled">Canceled</label>
                </div>

                <input class="btn btn-primary mt-3" type="submit" value="Add filter">
            </form>

        </div>

    </div>


    <table class="table table-striped table-bordered mt-3 mb-1">

        <thead>
            <th>Reservation Number</th>
            <th>Guardian ID</th>
            <th>Price</th>
            <th>Pets</th>
            <th>Dates</th>
            <th>State</th>
            <th>Action</th>
            <th>Chat</th>
        </thead>

        <tbody>
            <?php
            //$idCont es el número de reserva (Contador de reservas del usuario)
            $idCont = 1;
            foreach ($reservations as $reservation) {
            ?>
                <tr>
                    <td><?php echo $idCont ?></td>

                    <td>
                        <form action="<?php echo FRONT_ROOT . "Owner/ViewGuardianProfile" ?>" method=POST>

                            <input type="hidden" name="id" value="<?php echo encrypt($reservation->getGuardian_id()); ?>">
                            <input type="hidden" name="back" value="reservationsList">
                            <button class="btn btn-primary mt-2">Guardian Profile</button>

                        </form>

                    </td>
                    <td>$<?php echo $reservation->getPrice() ?></td>
                    <td>
                        <a class="btn btn-warning" data-bs-toggle="collapse" href="#pets-<?php echo $idCont ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
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
                        <?php switch ($reservation->getState()) {
                            case "Payment pending":
                        ?>
                                <form action="<?php echo  FRONT_ROOT . "Payment/ShowPaymentCupon" ?> " method="post">

                                    <button class="btn btn-success" type="submit"> Pay </button> <input type="hidden" name="reservation_id" value="<?php echo encrypt($reservation->getId()) ?>"></input>
                                </form>
                                <form action="<?php echo FRONT_ROOT . "Reservation/cancelReservation" ?>" method="post">
                                    <input type="hidden" name="reservation_id" value="<?php echo encrypt($reservation->getId()) ?>"></input>
                                    <button class="btn btn-danger float-end" type="submit"> Cancel </button>
                                </form>

                                <?php

                                break; ?>

                            <?php
                            case "Paid":
                            ?><form action="<?php echo  FRONT_ROOT . "Payment/ShowPayment" ?> " method="post">
                                    <button class="btn viewPaymentButton" type="submit"> View Payment </button> <input type="hidden" name="reservation_id" value="<?php echo encrypt($reservation->getId()) ?>"></input>
                                </form><?php

                                        break; ?>

                            <?php
                            case "Pending":
                            ?><form action="<?php echo FRONT_ROOT . "Reservation/cancelReservation" ?>" method="post">
                                    <input type="hidden" name="reservation_id" value="<?php echo encrypt($reservation->getId()) ?>"></input>
                                    <button class="btn btn-danger" type="submit"> Cancel </button>
                                </form>

                        <?php } ?>
                    </td>
                    <td>
                        <form action="<?php echo  FRONT_ROOT . "Chat/ShowChat" ?> " method="post">
                            <button class="btn viewChatButton" type="submit"> View Chat </button> <input type="hidden" name="idReceiver" value="<?php echo encrypt($reservation->getGuardian_id()) ?>"></input>
                        </form>
                    </td>
                </tr>

                <tr class="collapse" id="pets-<?php echo $idCont ?>">
                    <td colspan="8">
                        <table class="table table-bordered petsTable">

                            <thead>
                                <th>Reservation Pets</th>
                            </thead>

                            <tbody>

                                <?php foreach ($reservation->getPets() as $pet) {
                                ?>
                                    <tr>
                                        <td class="petTableColumn"><img src="<?php echo "../" . IMG_PATH .  $pet->getId() . "/" . $pet->getPet_img(); ?> " alt="pet_photo" height="100" width="100"> </td>
                                        <td class="petTableColumn"><?php echo $pet->getName() ?> </td>
                                        <td class="petTableColumn"><?php echo $pet->getBreed() ?> </td>
                                        <td class="petTableColumn"><?php echo ucfirst($pet->getType()) ?> </td>
                                        <td class="petTableColumn">

                                            <?php ShowValuePetSize($pet->getSize()) ?>

                                        </td>

                                        <td class="petTableColumn"><img src="<?php echo "../" . IMG_PATH .  $pet->getId() . "/" . $pet->getVaccination_plan(); ?> " alt="vac note" height="100" width="100"></td>
                                        <td class="petTableColumn"><?php echo $pet->getObservation() ?> </td>
                                        <td class="petTableColumn"> <a class="btn btn-primary" href=" <?php echo $pet->getPet_video();   ?>" target="_blank" alt="pet video"> Video </a> </td>
                    </td>

                <?php

                                }
                ?>

                </tr>

        </tbody>

    </table>
    </td>
    </tr>

<?php $idCont++;
            } ?>
</tbody>

</table>

<br>

<a href=<?php echo FRONT_ROOT . "Owner/HomeOwner" ?>><button class="btn btn-dark ">Back</button></a>

<script>
    alertMessage(<?php echo $alert; ?>)
</script>

</body>

</html>