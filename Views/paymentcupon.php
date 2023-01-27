<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="../Views/css/paymentcupon.css">

    <title>Payment coupon</title>
</head>

<body class="ms-2 me-2">

    <!-- --------------------------------------------------------------------------------------------- -->

    <h1 class="fixed-top p-2">Payment Coupon</h1>

    <div class="row h-100 w-100 d-flex">

        <div class="row h-100 w-100 d-flex">

            <div class="col-sm-4 border border-dark rounded m-auto align-items-center pt-2 pb-3 borderDiv">

                <table class="table table-bordered mt-3 paymentTable">

                    <thead>
                        <tr>
                            <th colspan="4">
                                <h2>Pet Hero</h2>
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <th colspan="2">Date</th>
                            <td colspan="2"><? //php echo $arrayPayment["date"] 
                                            ?> - </td>
                        </tr>

                        <tr>
                            <th>Guardian</th>
                            <td><?php echo $coupon["guardianName"] ?></td>
                            <th>Guardian CUIL</th>
                            <td><?php echo $coupon["guardianCUIL"] ?></td>
                        </tr>

                        <tr>
                            <th>Owner</th>
                            <td><?php echo $coupon["ownerName"] ?></td>
                            <th>Owner DNI</th>
                            <td><?php echo $coupon["ownerDNI"] ?></td>
                        </tr>

                        <tr>
                            <th colspan="2">Import</th>
                            <td colspan="2"><b>$<?php echo $coupon["import"] ?></b> (1/2)</td>
                        </tr>

                        <tr>
                            <th colspan="2">Description</th>
                            <td colspan="2"><b>Pet-sitting reservation | <?php echo $coupon["daysAmount"] ?> days | <?php echo $coupon["petsAmount"] ?> pet/s</b></td>
                        </tr>

                    </tbody>

                </table>

                <!-- ID a la vista -->

                <span>
                    <form action="<?php echo  FRONT_ROOT . "Payment/ShowMakePayment" ?>" method="post" style="display:inline">
                        <button class="btn btn-success" type="submit"> Pay </button> <input type="hidden" name="reservation_id" value="<?php echo encrypt($reservation->getId())
                                                                                                                                        ?>"></input>
                    </form>

                    <a class="float-end" href="<?php echo FRONT_ROOT . "Owner/ViewReservationsOwner" ?>"><button class="btn btn-dark" type="submit"> Back</button></a>


                </span>

            </div>

        </div>

    </div>

</body>

</html>

<!-- <h1>payment cupon</h1>

    <table border="fat">
        <thead>
            <tr>

                <th style="width: 150px;">Guardian name</th>
                <th style="width: 150px;">Guardian last name</th>
                <th style="width: 150px;">reservation dates</th>
                <th style="width: 150px;">amount to pay</th>


            </tr>

        </thead>

        <tbody>

            <td><?php // echo $guardian->getName() 
                ?> </td>
                <td><?php // echo $guardian->getLast_name()
                    ?> </td>
                <td><?php // echo implode($separator = " / ", $reservation->getDates())  
                    ?> </td>
                <td><?php // echo $reservation->getPrice() / 2  
                    ?> </td>
    
            </tbody>
    
        </table>
    
        <form action="<?php // echo  FRONT_ROOT . "Payment/ShowMakePayment" 
                        ?> " method="post">
            <button class="btn btn-success" type="submit"> Pay </button> <input type="hidden" name="reservation_id" value="<?php // echo $reservation->getId() 
                                                                                                                            ?>"></input>
        </form> -->