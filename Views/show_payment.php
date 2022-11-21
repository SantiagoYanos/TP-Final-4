<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment_data</title>
</head>

<body class="ms-2 me-2">



    <h1>Your payment</h1>


    <table class="table table-striped table-bordered" style="text-align:center;" border="2">
        <thead>
            <tr>

                <th style="width: 150px;">amount</th>
                <th style="width: 150px;">date</th>
                <th style="width: 150px;">payment number</th>
                <th style="width: 150px;">owner's name</th>
                <th style="width: 150px;">guardian's name</th>
                <th style="width: 150px;">price</th>


            </tr>

        </thead>

        <tbody>
            <tr>
                <td><?php echo $arrayPayment["amount"] ?> </td>
                <td><?php echo $arrayPayment["date"] ?> </td>
                <td><?php echo $arrayPayment["payment_number"] ?> </td>
                <td><?php echo $arrayPayment["owner_name"] ?></td>
                <td><?php echo $arrayPayment["guardian_name"] ?></td>
                <td><?php echo $arrayPayment["price"] ?></td>





            </tr>

        </tbody>





    </table>


    <form action="<?php echo FRONT_ROOT . "Owner/ViewReservationsOwner" ?>" method="post">
        <button type="submit"> back</button>
    </form>
</body>

</html>