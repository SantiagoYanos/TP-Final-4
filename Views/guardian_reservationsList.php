<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="../Views/css/guardianList.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
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

            var_dump($reservations);

            foreach ($reservations as $reservation) {
            ?>
                <tr>
                    <td><?php echo $reservation->GetId() ?></td>
                    <td> <a href=<?php echo  FRONT_ROOT . "Guardian/ViewOwnerProfile?owner_id=" . $reservation->GetOwner_id() ?>><button class="btn btn-primary mt-2">Owner Profile</button></a> </td>
                    <td>$<?php echo $reservation->getPrice() ?></td>
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

                                    <!-- Meterlo en una función (o un a archivo calendario.js) -->

                                    <?php

                                    $calendario = "<script type='text/javascript'>
                                    $(function() {
                                        $('#" . $idCont . "').datepicker({

                                            multidate: true,
                                            format: 'yyyy-mm-dd'

                                        });
                                        
                                        ";

                                    if ($reservation->getDates()) {
                                        $calendario = $calendario . "$('#" . $idCont . "').datepicker('setDates',['" . join("','", $reservation->getDates()) . "'])";
                                    }

                                    $calendario = $calendario . "
                                        });
                                    </script>";
                                    echo $calendario;

                                    ?>

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
                                <button class="btn" style="background-color: purple; color: white" type="submit"> View payment </button>
                                <input type="hidden" name="reservation_id" value="<?php echo $reservation->getId() ?>"></input>
                            </form>
                            <?php break;
                            ?>

                    <?php } ?>
                    </td>
                    <td>
                        <form action="<?php echo  FRONT_ROOT . "Chat/ShowChat" ?> " method="post">
                            <button class="btn" type="submit" style="background-color: purple; color: white"> View Chat </button> <input type="hidden" name="idReceiver" value="<?php echo $reservation->getOwner_id() ?>"></input>
                        </form>
                    </td>

                </tr>

                <!-- No usar las ID's de las reservas directamente (de vuelta) -->

                <tr class="collapse" id="pets-<?php echo $reservation->getId() ?>">
                    <td colspan="7">
                        <table class="table table-bordered">

                            <thead>
                                <th>Reservation Pets</th>
                            </thead>

                            <tbody>

                                <?php foreach ($reservation->getPets() as $pet) {
                                ?>

                                    <!-- No usar la id de pets -->

                                    <tr>
                                        <td style="width: 150px;"><img src="<?php echo "../" . IMG_PATH .  $pet->getId() . "/" . $pet->getPet_img(); ?> " alt="pet_photo" height="100" width="100"> </td>
                                        <td style="width: 150px;"><?php echo $pet->getName() ?> </td>
                                        <td style="width: 150px;"><?php echo $pet->getBreed() ?> </td>
                                        <td style="width: 150px;"><?php echo ucfirst($pet->getType()) ?> </td>
                                        <td style="width: 150px;">

                                            <!-- Arreglar switch con un utils Size -->

                                            <?php switch ($pet->getSize()) {
                                                case 1:
                                                    echo "Big";
                                                    break;
                                                case 2:
                                                    echo "Medium";
                                                    break;
                                                case 3:
                                                    echo "Small";
                                                    break;
                                                default:
                                                    echo "Undefined";
                                                    break;
                                            }
                                            ?>

                                        </td>
                                        <td style="width: 150px;"><img src="<?php echo "../" . IMG_PATH .  $pet->getId() . "/" . $pet->getVaccination_plan(); ?> " alt="vac note" height="100" width="100"></td>
                                        <td style="width: 150px;"><?php echo $pet->getObservation() ?> </td>
                                        <!--<td> <iframe width="786" height="442" src="https://www.youtube.com/embed/A6dhKpvhNKY?autoplay=1&controls=0&" </iframe> </td>-->
                                        <td style="width: 150px;"> <a class="btn btn-primary" href=" <?php echo $pet->getPet_video();   ?>" target="_blank" alt="pet video"> Video </a> </td>
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

<!-- Juntar el alert con el archivo alertMessage -->

<?php
if ($alert) {
    echo " <script> alert('" . $alert . "'); </script>";
};
?>

<script type="text/javascript" src="../Views/js/datepicker_manager.js"></script>

<!-- Chequear el funcionamiento de esto -->

<script>
    const availableDatesJson = '<?php echo $availableDatesJson ?>'

    InitializeAvailableDates(availableDatesJson);
</script>

</body>

</html>