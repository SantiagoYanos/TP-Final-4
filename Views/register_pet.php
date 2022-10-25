<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Register</title>
</head>

<body>
    <h1>Add Pet</h1>
    <h2>Add your pet info: </h2><br>

    <form action="<?php echo FRONT_ROOT . "Pet/Add" ?>" method="post">
        <label for="name">Name: </label>
        <input type="text" name="name" placeholder="Name"></br>
        <label for="">Breed: </label>
        <input type="text" name="breed" placeholder="Breed"></br>

        <label for="observations">Observations: </label>
        <input type="text" name="observation" placeholder="observations"></br>
        <label for="pet_size">Pet Size: </label>
        <select name="pet_size" id="pet_size">
            <option value="small">Small</option>
            <option value="medium">Medium</option>
            <option value="big">Big</option>
        </select></br>

        <label for="type">Type: </label>
        <select name="type" id="type">
            <option value="dog">Dog</option>
            <option value="cat">Cat</option>
        </select></br>

        <label for="vaccination note"> vaccination note</label>
        <input type="file" name=" vaccination_note" placeholder="submit vac note photo"> <br>

        <label for="photo/video"> Add photo/video</label>
        <input type="file" name=" photo_video" placeholder="submit photo/video"> <br>
        <button type="submit" onclick="alertMessage()">Add Pet</button>

        <script>
            function alertMessage() {
                alert("Pet added successfully!");
            }
        </script>

    </form>
</body>

</html>