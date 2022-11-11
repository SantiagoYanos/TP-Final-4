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
    <title>Guardian List</title>
</head>

<body>


    <table class="table table-striped table-bordered mt-3 mb-1">

        <thead>
            <th>Nro Reserva</th>
            <th>Owner</th>
            <th>Price</th>
            <th>Pets</th>
            <th>Dates</th>
            <th>State</th>
            <th>Action</th>
            
        </thead>

        

        <tbody>
        <?php
        foreach ($reservations as $reservation) {
        ?>
          <tr>
            <td><?php echo $reservation->GetId() ?></td>
            <td> <a href=<?php echo  FRONT_ROOT . "Guardian/ViewOwnerProfile?owner_id= " . $reservation->GetOwner_id() ?> ><button class="mt-2">Owner Profile</button></a>  </td>
            <td><?php echo $reservation->getPrice() ?></td>
            <td>Show Pets</td>
            <td>Dates Calendar</td>
            <td><?php echo $reservation->getState() ?> </td>

            <td> 
                <form  action="<?php echo  FRONT_ROOT . "Reservation/acceptReservation" ?> " method="post"  >
                <button type= "submit"> Accept </button>  <input type="hidden" name="reservation" value="<?php echo $reservation->getId() ?>"></input> 
                </form>
                
                
                <form action="<?php echo  FRONT_ROOT . "Reservation/rejectReservation" ?> "method="post"  > 
                <button type= "submit"> Reject </button>  
                <input type="hidden" name="reservation" value="<?php echo $reservation->getId() ?>"></input> 
             
                </form> 
            </td>


          </tr>
        <?php } ?>
      </tbody>

    </table>

    <br>

    <a href=<?php echo FRONT_ROOT . "Guardian/HomeGuardian" ?>><button class="mt-2">Back</button></a>

</body>

</html>