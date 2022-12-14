<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/dec9278e05.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="..\Views\css\utils.css">

    <title>view_pets</title>
</head>

<body class="bImageFix ms-2 me-2" style="background-image: url(../Views/images/gary.png);">
    <h1>My pets</h1>

    <table class="table table-striped table-bordered" style="text-align:center; font-weight:bold" border="2">
        <thead>
            <tr>

                <!-- Un poco de css y se arregla -->

                <th style="width: 150px;">Photo</th>
                <th style="width: 150px;">Name</th>
                <th style="width: 150px;">Breed</th>
                <th style="width: 150px;">Type</th>
                <th style="width: 50px;">Size</th>
                <th style="width: 150px;">Vaccination note</th>
                <th style="width: 250px;">Observations</th>
                <th style="width: 150px;">Video</th>
                <th style="width: 150px;">Action</th>

            </tr>

        </thead>

        <tbody>
            <?php foreach ($petList as $pet) {
            ?>
                <tr>
                    <td><img src="<?php echo "../" . IMG_PATH .  $pet->getId() . "/" . $pet->getPet_img(); ?> " alt="pet_photo" height="100" width="100"> </td>
                    <td><?php echo $pet->getName() ?> </td>
                    <td><?php echo $pet->getBreed() ?> </td>
                    <td><?php echo ucfirst($pet->getType()) ?> </td>
                    <td><?php echo $pet->getSize() ?></td>
                    <td><img src="<?php echo "../" . IMG_PATH .  $pet->getId() . "/" . $pet->getVaccination_plan(); ?> " alt="vac note" height="100" width="100"></td>
                    <td><?php echo $pet->getObservation() ?> </td>
                    <!--<td> <iframe width="786" height="442" src="https://www.youtube.com/embed/A6dhKpvhNKY?autoplay=1&controls=0&" </iframe> </td>-->
                    <td> <a class="btn btn-primary" href=" <?php echo $pet->getPet_video();   ?>" target="_blank" alt="pet video"> Video </a> </td>

                    <td>
                        <form id=<?php echo $pet->getId(); ?> action="<?php echo FRONT_ROOT . "Pet/deletePet" ?>" method="post">
                            <input type="hidden" name="petId" value="<?php echo $pet->getId() ?>"></input>
                        </form>
                        <button type="submit" class="btn btn-danger" onclick="confirming(<?php echo $pet->getId(); ?>)">delete</button>

                        <!-- Hacer una funci??n -->

                        <script>
                            function confirming(id) {
                                var txt;
                                if (confirm("are you sure you want to delete this pet?")) {
                                    txt = "You pressed OK!";
                                    document.getElementById(id).submit();
                                } else {
                                    txt = "You pressed Cancel!";
                                }

                            }
                        </script>


                    </td>
                <?php
            }
                ?>
                </tr>
        </tbody>

    </table>
    <div>
        <form action="<?php echo FRONT_ROOT . "Pet/ShowRegisterPet" ?>" method="post">
            <button class="btn btn-warning border-dark mb-2" type="submit">Add new pet</button>
        </form>

        <form action=<?php echo FRONT_ROOT . "Owner/HomeOwner" ?>>
            <button class="btn btn-dark" type="submit">Back</button>
        </form>


</body>

</html>