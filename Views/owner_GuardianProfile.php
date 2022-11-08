<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/dec9278e05.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../utils/multiselect_dropdown.js"></script>
    <style type="text/css">
        select{
            width: 30em;
            height: 30em;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <title>Guardian Profile</title>
</head>

<body>

    <h1><?php echo $guardian->getName() ?>'s profile</h1> <i class="fa fa-house"></i>


    <h2>Reputation</h2>

    <div class="container">

        <b>0 Stars</b>
        <b class="float-end">5 Stars</b>

        <div class="progress mb-3">
            <div class="progress-bar" style="width:<?php echo (($guardian->getType_Data()->getReputation() * 100) / 5) ?>%"></div>
        </div>

        <div class="container align-items-end">

            <table class="table table-striped table-bordered mt-3 mb-1">

                <tbody>

                    <tr>
                        <th>Name</th>
                        <td><?php echo $guardian->getName() ?></td>
                    </tr>

                    <tr>
                        <th>Last Name</th>
                        <td><?php echo $guardian->getLast_name() ?></td>
                    </tr>

                    <tr>
                        <th>Adress</th>
                        <td><?php echo $guardian->getAdress() ?></td>
                    </tr>

                    <tr>
                        <th>Cuil</th>
                        <td><?php echo $guardian->getType_Data()->getCuil() ?></td>
                    </tr>

                    <tr>
                        <th>Phone</th>
                        <td><?php echo $guardian->getPhone() ?></td>
                    </tr>

                    <tr>
                        <th>Dog Size Preference</th>
                        <td><?php echo ucwords($guardian->getType_Data()->getPreferred_size()) ?></td>
                    </tr>

                    <tr>
                        <th>Cat Size Peference</th>
                        <td><?php echo ucwords($guardian->getType_Data()->GetPreferred_size_cat()) ?></td>
                    </tr>

                    <tr>
                        <th>Birth Date</th>
                        <td><?php echo $guardian->getBirth_date() ?></td>
                    </tr>

                    <tr>
                        <th>Price</th>
                        <td><?php if ($guardian->getType_Data()->getPrice() == NULL) {
                                echo "UNASSIGNED";
                            } else {
                                echo "$" . $guardian->getType_Data()->getPrice();
                            }
                            ?></td>
                    </tr>

                </tbody>

            </table>

        </div>

        <a href=<?php echo FRONT_ROOT . "Owner/SearchGuardian" ?>><button class="mt-2">Back</button></a>

        <hr>

        <h3>Make Reservation</h3>

        <!-----------SELECCION DE PETS------------------------------------------------------------------------------------->         

        <form action=<?php echo FRONT_ROOT . "Reservation/MakeReservation" ?> method="post">
            <div class="container align-items-end">
                <div>
                    <label for="pets_ids">Select Your Pets: </label>
                    <select name="pets_ids" id="pets_ids" multiple required>
                        <?php foreach ($petList as $pet)?>
                        <option name="<?php $pet->getName()?>" value=<?php $pet->getId()?>><?php echo $pet->getName() ?></option>
                    </select></br>

                </div>
            </div>
        
        <!-----------SELECCION DE FECHAS-----------------------------------------------------------------------------------> 

            <div class="container align-items-end">
                <div>

                    <label for="dates">Select Dates: </label>

                    <div>
                        <section class="container">

                            <div class="input-group date mb-3" id="datepicker">
                                <input name="reservation_dates" type="text" class="form-control" hidden>
                                <span class="input-group-append">
                                    <span class="input-group-text bg-white">
                                        <i class="fa fa-calendar pt-1 pb-1"></i>
                                    </span>
                                </span>
                            </div>

                        </section>

                        <?php

                        $calendario = "<script type='text/javascript'>
                        $(function() {
                            $('#datepicker').datepicker({

                                multidate: true,
                                format: 'yyyy-mm-dd',
                                enableOnReadonly: true

                            });
                            
                            ";

                        if ($guardian->getType_data()->getAvailable_date()) {
                            $calendario = $calendario . "$('#datepicker').datepicker('setDates',['" . join("','", $guardian->getType_data()->getAvailable_date()) . "'])";
                        }

                        $calendario = $calendario . "
                            });
                        </script>";

                        echo $calendario;

                        ?>

                    </div>
                </div>
            </div> 

            <input type="hidden" name="guardian_id" value="<?php echo $guardian->getID() ?>"></input>
            
            <button type="submit">Make Reservation</button></br>
        </form>

</body>

</html>