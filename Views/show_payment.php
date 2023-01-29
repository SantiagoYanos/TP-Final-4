<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Payment Data</title>
</head>

<body class="ms-2 me-2">

    <h1 class="fixed-top p-2">Your payment</h1>

    <div class="row h-100 w-100 d-flex">

        <div class="col-sm-4 border rounded m-auto align-items-center pt-2 pb-3 borderDiv">

            <b>Payment Number: <?php echo $arrayPayment["payment_number"] ?></b>

            <table class="table mt-3">

                <!-- <th style="width: 150px;">amount</th>
                        <th style="width: 150px;">date</th>
                        <th style="width: 150px;">payment number</th>
                        <th style="width: 150px;">owner's name</th>
                        <th style="width: 150px;">guardian's name</th>
                        <th style="width: 150px;">price</th> -->

                <tbody>

                    <tr>
                        <th>Payment Date</th>
                        <td><?php echo $arrayPayment["date"] ?></td>
                    </tr>

                    <tr>
                        <th>Owner</th>
                        <td><?php echo $arrayPayment["owner_name"] ?></td>
                    </tr>

                    <tr>
                        <th>Guardian</th>
                        <td><?php echo $arrayPayment["guardian_name"] ?></td>
                    </tr>

                    <tr>
                        <th>Total Price</th>
                        <td><b>$<?php echo $arrayPayment["price"] ?></b></td>
                    </tr>

                    <tr>
                        <th>Amount Payed</th>
                        <td><b>$<?php echo $arrayPayment["amount"] ?></b></td>
                    </tr>

                </tbody>

            </table>

            <!-- Hay que encriptar el email -->

            <form action="<?php echo FRONT_ROOT . "Payment/SendEmailPayment" ?>" method="post">
                <div class="control-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <button class="btn btn-success" type="submit">Send Receipt</button>
            </form>


            <?php if ($_SESSION["type"] == "guardian") { ?>

                <a href="<?php echo FRONT_ROOT . "Guardian/ViewReservations" ?>"><button class="btn btn-dark" type="submit"> Back</button></a>

            <?php } else { ?>

                <a href="<?php echo FRONT_ROOT . "Owner/ViewReservationsOwner" ?>"><button class="btn btn-dark" type="submit"> Back</button></a>

            <?php } ?>

        </div>

    </div>

</body>

</html>