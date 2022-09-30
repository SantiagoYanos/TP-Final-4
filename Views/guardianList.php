<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="css/guardianList.css" rel="stylesheet">
    <title>Guardian List</title>
</head>
<body>

    <form action="">

    <div class="mb-1 mt-1">
    <input type="search" class="form-control" id="name" placeholder="Search" name="name">
    </div>

    <table class="table table-bordered">
    <tbody>
      <tr>
        <th>Rating</th>
        <td><input type="number" step="0.1" name="rating" min=0 max=5></td>
      </tr>

      <tr>
      <th>Pet size</th>
      <td>
            <select class="form-select">
            <option>*</option>
            <option>Small</option>
            <option>Medium</option>
            <option>Big</option>
            </select>
      </td>
      </tr>

      <tr>
      <th>Location</th>
        <td><input type="text" name="location" id="location"></td>
      </tr>

      <tr>
      <th>Price</th>
       <td><input type="number" step="0.01" id="price" name="price" min=0></td>
      </tr>

    </tbody>
  </table>


    <button type="submit">Filter</button>

    <table class="table table-bordered">

        <thead>
            <th><button class="day-option">Monday</button></th>
            <th><button class="day-option">Tuesday</button></th>
            <th><button class="day-option">Wednesday</button></th>
            <th><button class="day-option">Thursday</button></th>
            <th><button class="day-option">Friday</button></th>
            <th><button class="day-option">Saturday</button></th>
            <th><button class="day-option">Sunday</button></th>
        </thead>
    </table>

    </form>


    <table class="table table-striped table-bordered">
        <thead>
            <th>Name</th>
            <th>Addres</th>
            <th>Rating</th>
            <th>Pet size preference</th>
            <th>Price</th>
        </thead>

        <tbody>
            <tr>
                <td>Prueba</td>
                <td>Prueba</td>
                <td>Prueba</td>
                <td>Prueba</td>
                <td>Prueba</td>
            </tr>
        </tbody>

    </table>

    
    
</body>
</html>