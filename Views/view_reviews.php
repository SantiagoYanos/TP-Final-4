<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
</head>
<body>
    <h1>Reviews from the guardian </h1>
    
    
    <table class="table table-striped table-bordered" style="text-align:center; font-weight:bold" border="2">
        <thead>
            <tr>
                <th style="width: 150px;">Name </th>
                <th style="width: 150px;">Comment </th>
                <th style="width: 150px;">Rating </th>
                <th style="width: 150px;">Date </th>
            </tr>

        </thead>

        <tbody>
            
            <?php foreach ($total as $review) 
            { ?>
                <tr>
                <td style="width: 150px;"><?php echo $review->getOwner_name() ?></td>
                <td style="width: 150px;"><?php echo $review->getComment() ?></td>
                <td style="width: 150px;"><?php echo $review->getRating() ?></td>
                <td style="width: 150px;"><?php echo $review->getDate() ?></td>
            <?php } ?>
            </tr>
        </tbody>

    </table>

    <div>
        <a href=<?php echo FRONT_ROOT . "Guardian/ViewReservations" ?>><button>Back</button></a>
    </div>

</body>
</html>