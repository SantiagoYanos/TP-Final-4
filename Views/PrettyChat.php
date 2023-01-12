<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        tr:nth-child(even) {
            background-color: #dddddd;
        }
        .form-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            background-color: #f5f5f5;
            border-radius: 5px;
        }
        .form-container label {
            font-weight: bold;
            margin-bottom: 8px;
        }
        .form-container input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 20px;
            font-size: 16px;
        }
        .form-container button[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .form-container button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th style="width: 150px;">Date</th>
                <th style="width: 150px;">Sender</th>
                <th style="width: 150px;">Message</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($total as $message) { ?>
                <tr>
                    <td><?php echo $message->getDate() ?></td>
                    <td><?php echo $message->getSender() ?></td>
                    <td><?php echo $message->getDescription() ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="form-container">
        <form action="<?php echo FRONT_ROOT . "Chat/SendMessage" ?>" method="GET">
            <label for ="" > message</label>
            <input type="text" name="description" required>
            <input type="hidden" name="userId" value="<?php echo $idReceiver ?>">
            <button class="btn btn-dark" type="submit">Send</button>
        </form>
    </div>
</body>
</html>