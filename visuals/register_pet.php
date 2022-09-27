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

    <form action="..." method="post">
        <label for="name">Name: </label>
        <input type="text" name="name" placeholder="Name"></br>
        <label for="">Breed: </label>
        <input type="text" name="Breed" placeholder="Breed"></br>
       
        
        
        <label for="observations">Observations: </label>
        <input type="text" name="observations" placeholder="observations"></br>
        <label for="pet_size">Pet Size: </label>
        <select name="pet_size" id="pet_size">
            <option value="small">Small</option>
            <option value="medium">Medium</option>
            <option value="big">Big</option>
        </select></br>

        <label for="vaccination note"> vaccination note</label>
        <input type="file" name=" vaccionation note" placeholder="submit vac note photo" > <br>

      

        


    
        <button type="submit">Add Pet</button>
    </form>
</body>
</html>