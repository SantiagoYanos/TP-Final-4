<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment document</title>
</head>

<body>

    <h1>payment cupon</h1>

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

            <td><?php echo $guardian->getName() ?> </td>
            <td><?php echo $guardian->getLast_name() ?> </td>
            <td><?php echo implode($separator = " / ", $reservation->getDates()) ?> </td>
            <td><?php echo $reservation->getPrice() / 2 ?> </td>

        </tbody>

    </table>

    <form action="<?php echo  FRONT_ROOT . "Payment/ShowMakePayment" ?> " method="post">
        <button class="btn btn-success" type="submit"> Pay </button> <input type="hidden" name="reservation_id" value="<?php echo $reservation->getId() ?>"></input>
    </form>





</body>

</html>