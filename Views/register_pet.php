<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Register</title>
</head>

<body class="ms-2 me-2">
    <h1>Add Pet</h1>
    <h2>Add your pet info: </h2><br>

    <form action="<?php echo FRONT_ROOT . "Pet/Add" ?>" method="post" enctype="multipart/form-data" class="bg-dark-alpha p-5">
        <label for="name">Name: </label>
        <input type="text" name="name" placeholder="Name"></br>
        <label for="">Breed: </label>
        <input type="text" name="breed" placeholder="Breed"></br>

        <label for="observations">Observations: </label>
        <input type="text" name="observation" placeholder="observations"></br>
        <label for="pet_size">Pet Size: </label>
        <select name="pet_size" id="pet_size">
            <option value=3>Small</option>
            <option value=2>Medium</option>
            <option value=1>Big</option>
        </select></br>

        <label for="type">Type: </label>
        <select name="type" id="type">
            <option value="dog">Dog</option>
            <option value="cat">Cat</option>
        </select></br>

        <label for="vaccination note"> vaccination note</label>
        <input type="file" name=" file" placeholder="submit vac note photo"> <br>

        <label for="photo"> Add photo</label>
        <input type="file" name=" file1" placeholder="submit photo"> <br>

        <label for="video"> Add video url</label>
        <input type="text" name=" pet_video" placeholder="submit video"> <br>


        <button type="submit" onclick="alertMessage()">Add Pet</button>

        <script>
            function alertMessage() {
                alert("Pet added successfully!");
            }
        </script>

    </form>
</body>

</html>