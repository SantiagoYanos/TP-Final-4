<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <style>
        .form-group {
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center mb-5">Reviews from the guardian</h1>
        <table class="table table-striped table-bordered text-center" style="table-layout: fixed;">
            <?php if ($noreview == 0) { ?>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Comment</th>
                        <th>Rating</th>
                        <th>Date</th>
                    </tr>
                </thead><?php } ?>
            <tbody>
                <?php
                if ($noreview == 0) {
                    foreach ($total as $review) { ?>
                        <tr>
                            <td><?php echo $review->getOwner_name(); ?></td>
                            <td style="overflow-wrap: break-word;"><?php echo $review->getComment(); ?></td>
                            <td><?php echo $review->getRating(); ?></td>
                            <td><?php echo $review->getDate(); ?></td>
                        </tr>
                <?php }
                } else {
                } ?>
            </tbody>
        </table>

        <?php if ($guardianId != $_SESSION["id"]) { ?>

            <div class="mt-5">
                <form action="<?php echo FRONT_ROOT . "Review/makereview" ?>" method="post">
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
                    <input type="hidden" name="guardianId" value="<?php if ($noreview == 0) {
                                                                        echo $review->getGuardianId();
                                                                    } else {
                                                                        echo $noreview;
                                                                    } ?>">
                    <button type="submit" class="btn btn-primary">Make Review</button>
                </form>
            </div>

        <?php

        }

        ?>



        <div class="text-center mt-5">
            <a href="<?php echo $backLink; ?>">
                <button class="btn btn-secondary">Back</button>
            </a>
        </div>
    </div>
</body>

</html>