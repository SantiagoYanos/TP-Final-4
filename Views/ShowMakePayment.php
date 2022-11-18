<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>makePayment</title>
</head>
<body>

<form action="<?php echo FRONT_ROOT . "Payment/ShowMakePayment" ?>" method="post">


<div class="txt_field">
                <input type="text" name="card_number" required></br>
                <label for="name">Card number </label>
            </div>
            <div class="txt_field">
                <input type="text" name="card_type" required></br>
                <label for="">Card type </label>
            </div>
            <div class="txt_field">
                <input type="text" name="Card_Owners_name" required></br>
                <label for="">Card owener's name </label>
            </div>

            <div class="txt_field">
                <input type="text" name="expiring_date" required></br>
                <label for="">Expiring date </label>
            </div>

            <div class="txt_field">
                <input type="text" name="security_code" required></br>
                <label for="">Security code </label>
            </div>
         
         
                
           
            <input name="amount" value="<?php echo $reservation->getAmount() ?>" hidden>
            <input name="reservation_id" value="<?php echo $reservation->getId() ?>" hidden>
            <input name="owner_id" value="<?php echo $reservation->getOwner_id() ?>" hidden>
            <input name="guardian_id" value="<?php echo $reservation->getGuardian_id() ?>" hidden>

            <button type="submit"> Pay</button>







</form>



    
</body>
</html>