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
                        <th>Name </th>
                    </div>
                    <th>Comment </th>
                    <th>Rating </th>
                    <th>Date </th>
                </tr>
            </thead>

            <!-- Id a la vista -->

            <tbody>
                <?php foreach ($total as $review) { ?>
                    <tr>
                        <td><?php echo $review->getOwner_name() ?></td>
                        <td><?php echo $review->getComment() ?></td>
                        <td><?php echo $review->getRating() ?></td>
                        <td><?php echo $total[0]->getGuardian_id() ?></td>
                    <?php } ?>
                    </tr>
            </tbody>
        </table>

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
            <<<<<<< HEAD <form action="<?php echo  FRONT_ROOT . "Owner/ViewGuardianProfile" ?>" method="post">
                <button class="btn btn-success" type="submit">Back</button> <input type="hidden" name="guardian_id" value="<?php echo $total[0]->getGuardian_id() ?>"></input>
                </form>
        </div>

        =======
        <form action="<?php echo FRONT_ROOT . "Review/makereview" ?>" method="post">

            <div class="txt_field">
                <label for="rating">Rating: </label>
                <select name="rating" id="rating" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select></br>


            </div>


            <div>
                <label for="comment">comment</label>
                <input type="text" name="comment"></br>
            </div>

            <!-- Se ve la ID -->

            <input type="hidden" name="guardianId" value="<?php echo $review->getGuardianId() ?>"></input>


            <div>
                <button type="submit">make review</button>
            </div>

        </form>
    </div>

    <div>
        <a href=<?php echo FRONT_ROOT . "Guardian/ViewReservations" ?>><button>Back</button></a>
        >>>>>>> e5e3a3b699e6ff81423717de7244f8d20331906d
    </div>

</body>

</html>