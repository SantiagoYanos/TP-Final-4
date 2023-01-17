<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/dec9278e05.js" crossorigin="anonymous"></script>
    <title>Payment Data</title>
</head>

<body style="height: 100vh" class="ms-2 me-2">

    <h1 class="fixed-top p-2">Your payment</h1>

    <div class="row h-100 w-100 d-flex">

        <div class="col-sm-4 border rounded m-auto align-items-center pt-2 pb-3" style="border-width: 5px !important; border-color: purple !important">

            <b>Payment Number: <?php echo $arrayPayment["payment_number"] ?></b>

            <!-- Border error -->

            <table class="table mt-3" style="text-align:center;" border="2">



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

            <!-- Se puede mejorar seguramente -->

            <?php if ($_SESSION["type"] == "guardian") { ?>

                <a href="<?php echo FRONT_ROOT . "Guardian/ViewReservations" ?>"><button class="btn btn-dark" type="submit"> Back</button></a>

            <?php } else { ?>

                <a href="<?php echo FRONT_ROOT . "Owner/ViewReservationsOwner" ?>"><button class="btn btn-dark" type="submit"> Back</button></a>

            <?php } ?>



        </div>

    </div>

</body>

</html>