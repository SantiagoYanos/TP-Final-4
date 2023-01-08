<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>chat</title>
</head>
<body>

<table class="table table-striped table-bordered" style="text-align:center; font-weight:bold" border="2">
        <thead>
            <tr>

                <th style="width: 150px;">date</th>
                <th style="width: 150px;">sender</th>
                <th style="width: 150px;">message</th>
                
             

            </tr>

        </thead>

        <tbody>
            <?php foreach ($messages as $message) {
            ?>
                <tr>
                    
                    <td><?php echo $message->getDate() ?> </td>
                    <td><?php echo $message->getSender() ?> </td>
                    <td><?php echo $message->getDescription() ?> </td> 
                <?php
            }
                ?>
                </tr>
        </tbody>



        <form action=<?php echo FRONT_ROOT . "Chat/SendMessage" ?> method="GET">
            <label for="" > message</label>
            <input type="text" name="description" required></br>
            <input type="hidden" name="user_id" value="<?php echo $user->getID() ?>"></input>
            <button class="btn btn-dark" type="submit">send</button>
        </form>

    </table>







    
</body>
</html>