<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
  <link href="./css/guardianList.css" rel="stylesheet">
  <title>Guardian List</title>
</head>

<body>

  <form action="">

    <div class="mb-1 mt-1">
      <input type="search" class="form-control" id="name" placeholder="Search" name="name" value="<?php echo $name ?>">
    </div>

    <table class="table table-bordered">
      <tbody>
        <tr>
          <th>Rating (Min)</th>
          <td><input type="number" step="0.1" name="rating" min=0 max=5 value="<?php echo $rating ?>"></td>
        </tr>

        <tr>
          <th>Pet size</th>
          <td>
            <select class="form-select" name="prefered_size" id="prefered_size" value="<?php echo $prefered_size ?>">
              <option <?php if ($prefered_size == null) {
                        echo "selected='selected'";
                      } ?> value="*">*</option>
              <option <?php if ($prefered_size == "small") {
                        echo "selected='selected'";
                      } ?> value="small">Small</option>
              <option <?php if ($prefered_size == "medium") {
                        echo "selected='selected'";
                      } ?> value="medium">Medium</option>
              <option <?php if ($prefered_size == "big") {
                        echo "selected='selected'";
                      } ?>value="big">Big</option>
            </select>
          </td>
        </tr>

        <tr>
          <th>Location</th>
          <td><input type="text" name="location" id="location" value="<?php echo $location ?>"></td>
        </tr>

        <tr>
          <th>Price (Max)</th>
          <td><input type="number" step="0.01" id="price" name="price" min=0 value="<?php echo $price ?>"></td>
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
      <?php
      foreach ($guardians as $guardian) {
      ?>
        <tr>
          <td><?php echo $guardian->GetName() ?></td>
          <td><?php echo $guardian->getAdress() ?></td>
          <td><?php echo $guardian->getReputation() ?></td>
          <td><?php echo $guardian->getPrefered_size() ?></td>
          <td><?php echo $guardian->GetPrice() ?></td>
        </tr>

      <?php } ?>
    </tbody>

  </table>



</body>

</html>