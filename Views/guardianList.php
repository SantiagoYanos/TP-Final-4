<?php require_once(ROOT . "/Utils/selectSize.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

  <!-- CSS Files-->
  <link href="../Views/css/guardianList.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- JS Files -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

  <script type="text/javascript" src="../Views/js/alertMessage.js"></script>
  <script type="text/javascript" src="../Views/js/datepickerCreator.js"></script>

  <title>Guardian List</title>
</head>

<body class="ms-2 me-2">

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
          <th>Dog size</th>
          <td>

            <select class="form-select" name="preferred_size" id="preferred_size" value="<?php echo $preferred_size ?>">

              <?php createOptionsByIndex($preferred_size, $petSizesEnum); ?>

            </select>
          </td>
        </tr>

        <tr>
          <th>Cat size</th>
          <td>

            <select class="form-select" name="preferred_size_cat" id="preferred_size_cat" value="<?php echo $preferred_size_cat ?>">

              <?php createOptionsByIndex($preferred_size_cat, $petSizesEnum); ?>

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

    <h4 class="pb-1">Select Dates</h4>
    <div class="input-group date mb-3" id="datepicker">
      <input name="stringDates" type="text" class="form-control" hidden>
      <span class="input-group-append">
        <span class="input-group-text bg-white">
          <i class="fa fa-calendar pt-1 pb-1"></i>
        </span>
      </span>
    </div>

    <?php $dates =  "['" . join("','", $stringDates) . "']"; ?>

    <script>
      crearDatepicker("datepicker", <?php echo $dates; ?>, 'date("Y-m-d")');
    </script>

    </div>

    <div>
      <button class="btn btn-primary border-dark mb-3" type="submit" onclick="alertMessage('Filter added successfully!')">Add Filter</button>

  </form>

  <table class="table table-striped table-bordered">
    <thead>
      <th>Name</th>
      <th>Addres</th>
      <th>Rating</th>
      <th>Dog Size Preference</th>
      <th>Cat Size Preference</th>
      <th>Price</th>
      <th>Make Reservation</th>
    </thead>

    <tbody>
      <?php
      foreach ($guardians as $guardian) {
      ?>
        <tr>
          <td><?php echo $guardian->GetName() ?></td>
          <td><?php echo $guardian->getAdress() ?></td>
          <td><?php
              $reputation = $guardian->getType_data()->getReputation();

              if ($reputation) {
                echo number_format((float)$reputation, 1, ',', '');
              } else {
                echo "-";
              }
              ?></td>
          <td><?php echo ucfirst($guardian->getType_data()->getPreferred_size()) ?></td>
          <td><?php echo ucfirst($guardian->getType_data()->getPreferred_size_cat()) ?></td>
          <td>$<?php echo $guardian->getType_data()->GetPrice() ?></td>

          <form action=<?php echo FRONT_ROOT . "Owner/ViewGuardianProfile" ?> method=POST>
            <input type="hidden" name="id" value="<?php echo encrypt($guardian->getID()) ?>"></input>
            <input type="hidden" name="back" value="guardianList">
            <td><button class="btn btn-primary" type="submit">Check Profile</button></td>
          </form>
        </tr>
      <?php } ?>
    </tbody>

  </table>

  <form action=<?php echo FRONT_ROOT . "Owner/HomeOwner" ?>>
    <button class="btn btn-dark" type="submit">Back</button>
  </form>

  <script>
    alertMessage(<?php echo $alert; ?>)
  </script>

</body>

</html>