<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
  <link href="../Views/css/guardianList.css" rel="stylesheet">
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
            <select class="form-select" name="preferred_size" id="preferred_size" value="<?php echo $preferred_size ?>">
              <option <?php if ($preferred_size == null) {
                        echo "selected='selected'";
                      } ?> value="*">*</option>
              <option <?php if ($preferred_size == "small") {
                        echo "selected='selected'";
                      } ?> value="small">Small</option>
              <option <?php if ($preferred_size == "medium") {
                        echo "selected='selected'";
                      } ?> value="medium">Medium</option>
              <option <?php if ($preferred_size == "big") {
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

      <script>
        function select_Day(button_id) {

          const dayButton = document.getElementById(button_id)
          const buttonValue = document.getElementById(button_id + "_value")

          if (buttonValue.value == "") {
            buttonValue.value = "on";
            dayButton.style.borderColor = "blue"

          } else {
            buttonValue.value = "";
            dayButton.style.borderColor = "black"
          }

        }
      </script>

      <thead>
        <th><button id="monday" onClick="select_Day(this.id)" type="button" <?php if ($monday == "on") {
                                                                              echo "style='border-color:blue'";
                                                                            } ?> class="day-option">Monday</input>
            <input id="monday_value" name="monday" type="hidden" <?php if ($monday == "on") {
                                                                    echo "value='on'";
                                                                  } ?>>
        </th>
        <th><button id="tuesday" name="tuesday" onClick="select_Day(this.id)" type="button" <?php if ($tuesday == "on") {
                                                                                              echo "style='border-color:blue'";
                                                                                            } ?> class="day-option">Tuesday</input>
            <input id="tuesday_value" name="tuesday" type="hidden" <?php if ($tuesday == "on") {
                                                                      echo "value='on'";
                                                                    } ?>>
        </th>
        <th><button id="wednesday" name="wednesday" onClick="select_Day(this.id)" type="button" <?php if ($wednesday == "on") {
                                                                                                  echo "style='border-color:blue'";
                                                                                                } ?> class="day-option">Wednesday</input>
            <input id="wednesday_value" name="wednesday" type="hidden" <?php if ($wednesday == "on") {
                                                                          echo "value='on'";
                                                                        } ?>>
        </th>
        <th><button id="thursday" name="thursday" onClick="select_Day(this.id)" type="button" <?php if ($thursday == "on") {
                                                                                                echo "style='border-color:blue'";
                                                                                              } ?> class="day-option">Thursday</input>
            <input id="thursday_value" name="thursday" type="hidden" <?php if ($thursday == "on") {
                                                                        echo "value='on'";
                                                                      } ?>>
        </th>
        <th><button id="friday" name="friday" onClick="select_Day(this.id)" type="button" <?php if ($friday == "on") {
                                                                                            echo "style='border-color:blue'";
                                                                                          } ?> class="day-option">Friday</input>
            <input id="friday_value" name="friday" type="hidden" <?php if ($friday == "on") {
                                                                    echo "value='on'";
                                                                  } ?>>
        </th>
        <th><button id="saturday" name="saturday" onClick="select_Day(this.id)" type="button" <?php if ($saturday == "on") {
                                                                                                echo "style='border-color:blue'";
                                                                                              } ?> class="day-option">Saturday</input></th>
        <input id="saturday_value" name="saturday" type="hidden" <?php if ($saturday == "on") {
                                                                    echo "value='on'";
                                                                  } ?>>
        <th><button id="sunday" name="sunday" onClick="select_Day(this.id)" type="button" <?php if ($sunday == "on") {
                                                                                            echo "style='border-color:blue'";
                                                                                          } ?> class="day-option">Sunday</input>
            <input id="sunday_value" name="sunday" type="hidden" <?php if ($sunday == "on") {
                                                                    echo "value='on'";
                                                                  } ?>>
        </th>
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
          <td><?php echo $guardian->getPreferred_size() ?></td>
          <td><?php echo $guardian->GetPrice() ?></td>
        </tr>

      <?php } ?>
    </tbody>

  </table>



</body>

</html>