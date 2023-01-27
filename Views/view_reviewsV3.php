<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="../Views/css/review.css" type="text/css">

    <title>Reviews</title>
</head>

<body>

    <div class="container vh-100 h-100 p-4" name="maximum">
        <div class="h-100 px-4 pb-4 reviewBox" name="reviews">

            <!-- Formulario de nueva reserva !-->

            <div name="makeReservationInputs">

                <h1 class="text-center mt-2"><?php echo $guardian->getName(); ?>'s Reviews</h1>


                <?php if ($guardianId != $_SESSION["id"]) { ?>

                    <div class="mt-5">

                        <form action="<?php echo $formLink ?>" method="post">
                            <div class="form-group">
                                <label for="rating">Rating:</label>
                                <select class="form-control" name="rating" id="rating" required>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="comment">Comment:</label>
                                <input type="text" class="form-control" name="comment">
                            </div>

                            <!-- Id a la vista -->

                            <input type="hidden" name="guardianId" value="<?php if ($noreview == 0) {
                                                                                echo $guardian->getId();
                                                                            } else {
                                                                                echo $noreview;
                                                                            } ?>">
                            <br>

                            <!-- Id a la vista -->

                            <?php if ($ownerReview) { ?>
                                <input type="hidden" name="oldReviewId" value=<?php echo $ownerReview->getId(); ?>></input>
                                <button type="submit" class="btn btn-primary">Edit Review</button>

                            <?php } else { ?>
                                <button type="submit" class="btn btn-warning btn-outline-dark">Make Review</button>
                            <?php } ?>

                        </form>
                    </div>

                <?php

                }

                ?>

                <div class=" text-center">
                    <a href="<?php echo $backLink; ?>">
                        <button class="btn btn-secondary mt-2">Back</button>
                    </a>
                </div>
            </div>

            <!-- Listado de reviews ya hechas -->

            <div class="mt-3 reviewsList" name="reviewsList">

                <?php

                if ($noreview == 0) {
                    if ($guardianId != $_SESSION["id"] && $ownerReview) { ?>

                        <div class="border border-primary border-2 mx-3 my-4 pt-2 px-2">
                            <b><?php echo $ownerReview->getOwner_name(); ?></b><br>
                            <span>

                                <?php for ($i = 0; $i < 5; $i++) {

                                    if ($i < $ownerReview->getRating()) {
                                        echo "&#9733";
                                    } else {
                                        echo "&#9734";
                                    }
                                } ?>

                                <div class="ms-2 reviewDate"><?php echo $ownerReview->getDate(); ?></div>
                            </span>

                            <p class="mx-1 mt-2 reviewComment"><?php echo $ownerReview->getComment(); ?></p>

                        </div>

                    <?php }

                    foreach ($total as $review) { ?>

                        <div class="border border-dark mx-3 my-4 pt-2 px-2">
                            <b><?php echo $review->getOwner_name(); ?></b><br>
                            <span>

                                <?php for ($i = 0; $i < 5; $i++) {

                                    if ($i < $review->getRating()) {
                                        echo "&#9733";
                                    } else {
                                        echo "&#9734";
                                    }
                                } ?>

                                <div class="ms-2 reviewDate"><?php echo $review->getDate(); ?></div>
                            </span>

                            <p class="mx-1 mt-2 reviewComment"><?php echo $review->getComment(); ?></p>

                        </div>

                <?php }
                }
                ?>

            </div>

        </div>

    </div>

</body>

</html>