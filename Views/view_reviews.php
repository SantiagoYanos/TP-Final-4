<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\Views\css\styleViewReviews.css">
    <title>Reviews</title>
</head>
<body>
    <div class="center">
    <h1>Reviews from the guardian </h1>
    
    
     <table class="table table-striped table-bordered" style="text-align:center; font-weight:bold" border="2">
        <thead>
            <tr>
                <div class="txt_field">
                    <th style="width: 150px;">Name </th>
                </div>
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
                <td style="width: 150px;"><?php echo $total[0]->getGuardian_id() ?></td>
            <?php } ?>
            </tr>
        </tbody>
    </table>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <span class="heading">User Rating</span>
    <span class="fa fa-star checked"></span>
    <span class="fa fa-star checked"></span>
    <span class="fa fa-star checked"></span>
    <span class="fa fa-star checked"></span>
    <span class="fa fa-star"></span>
    <p>4.1 average based on 254 reviews.</p>
    <hr style="border:3px solid #f1f1f1">

    <div class="row">
    <div class="side">
        <div>5 star</div>
    </div>
    <div class="middle">
        <div class="bar-container">
        <div class="bar-5"></div>
        </div>
    </div>
    
    </div>

    <div>
        <form action="<?php echo  FRONT_ROOT . "Owner/ViewGuardianProfile" ?>" method="post">
            <button class="btn btn-success" type="submit">Back</button> <input type="hidden" name="guardian_id" value="<?php echo $total[0]->getGuardian_id() ?>"></input>
        </form>
    </div>

    </div>

</body>
</html>