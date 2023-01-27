<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript" src="../Views/js/alertMessage.js"></script>

    <title>Pet Register</title>
</head>

<body class="ms-2 me-2">
    <h1>Add Pet</h1>

    <div class="col-sm-4 border rounded border-warning pt-2 pb-3 m-auto petCol">

        <h2 class="ms-2 me-2">Add your pet info: </h2>

        <form action="<?php echo FRONT_ROOT . "Pet/Add" ?>" method="post" enctype="multipart/form-data" class="bg-dark-alpha ps-3 pe-3">
            <label class="form-label" for="name">Name </label>
            <input class="form-control" type="text" name="name" placeholder="Name"></br>

            <label class="form-label" for="type">Type </label>
            <select class="form-select" name="type" id="type">
                <option value="dog">Dog</option>
                <option value="cat">Cat</option>
            </select></br>

            <label class="form-label" for="">Breed </label>
            <input class="form-control" type="text" name="breed" placeholder="Breed"></br>

            <label class="form-label" for="pet_size">Pet Size: </label>
            <select class="form-select" name="pet_size" id="pet_size">
                <option value=3>Small</option>
                <option value=2>Medium</option>
                <option value=1>Big</option>
            </select></br>

            <label class="form-label" for="observations">Observations </label>
            <textarea class="form-control" name="observation" placeholder="Observations"></textarea></br>

            <label class="form-label" for="photo"> Add photo (PNG, JPG, etc.) </label>
            <input class="form-control" type="file" name=" file1" placeholder="submit photo"> <br>

            <label class="form-label" for="vaccination note"> Vaccination note (PNG, JPG, etc.)</label>
            <input class="form-control" type="file" name=" file" placeholder="submit vac note photo"> <br>

            <label class="form-label" for="video"> Add video URL</label>
            <input class="form-control" type="text" name=" pet_video" placeholder="Ex. https://youtu.be/dQw4w9WgXcQ"> <br>

            <div>
                <a href=<?php echo FRONT_ROOT . "Pet/PetList" ?>>
                    <div class="btn btn-dark float-end">Back</div>
                </a>
            </div>

            <button class="btn btn-outline-success" type="submit" onclick="alertMessage('Pet added successfully!')">Add Pet</button>

        </form>

    </div>

</body>

</html>