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
    <link rel="stylesheet" href="../Views/css/show_make_payment.css">

    <!-- JS Files -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <title>Make Payment</title>
</head>

<body class="ms-2 me-2">

    <h1 class="fixed-top p-2">Make Payment</h1>

    <div class="row h-100 w-100 d-flex">

        <div class="col-sm-4 border rounded border-success m-auto align-items-center pt-2 pb-3 borderDiv">

            <h4 class="text-center mb-3">New Payment</h4>

            <div class="mb-3">
                <label for="card_type" class="form-label">Card Type</label>
                <select class="form-select " aria-label="Select Card Type">
                    <option value="1">MasterCard</option>
                    <option value="2">Visa</option>
                    <option value="3">Zacoa</option>
                </select>
            </div>

            <div class="row g-2">

                <div class="col col-5 mb-3">
                    <label for="card_number" class="form-label">Card Number</label>
                    <input type="number" class="form-control" id="card_number" name="card_number" placeholder="Card Number">
                </div>

                <div class="col col-4 mb-3">
                    <label for="expiration_date" class="form-label">Expiration Date</label>
                    <input type="month" class="form-control" id="expiration_date" name="expiration_date" placeholder="Expiration Date">
                </div>

                <div class="col col-3 mb-3">
                    <label for="security_code" class="form-label">Security Number</label>
                    <input type="number" min="0" max="9999" class="form-control" id="security_code" name="security_code" placeholder="Ex. 1234">
                </div>
            </div>


            <div class="mb-3">
                <label for="Card_Owners_name" class="form-label">Card Owner's name</label>
                <input type="text" class="form-control" id="Card_Owners_name" name="Card_Owners_name" placeholder="Card Owner's name">
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="123-456-7890">
            </div>

            <div>
                <a href=<?php echo FRONT_ROOT . "Owner/ViewReservationsOwner" ?>><button class="btn btn-dark float-end">Back</button></a>
            </div>


            <form action="<?php echo FRONT_ROOT . "Payment/MakePayment" ?>" method="post">

                <!-- Ya está encriptado - HECHO -->

                <input name="price" value="<?php echo $encryptedPrice ?>" hidden>
                <input name="reservation_id" value="<?php echo  $encryptedReservation_id ?>" hidden>
                <input name="owner_id" value="<?php echo  $encryptedOwner_id ?>" hidden>
                <input name="guardian_id" value="<?php echo  $encryptedGuardian_id ?>" hidden>
                <button class="btn btn-outline-success " type="submit"> <b> Pay </b> </button>

            </form>

        </div>
    </div>

</body>

</html>