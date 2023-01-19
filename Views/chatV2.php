<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="../Views/css/chat.css" type="text/css">

    <title>Chat</title>
</head>

<body>

    <div class="container vh-100 h-100 p-4" name="maximum">
        <div class="border border-2 border-dark h-100 px-4" name="chat">

            <!-- Mensajes de volver, Perfil del Guardian y ver Reservas -->
            <div class="row align-items-center upperButtons" name="upperButtons">

                <span>
                    <!-- <button class="btn btn-dark" onclick="history.go(-1);">Back</button>-->
                    <a href="<?php echo $receiverLink ?>"><button class="btn btn-primary" type="button">Check Profile</button></a>
                    <a href="<?php echo $reservationsLink ?>" class="ms-2"><button class="btn btn-primary" type="button">View Reservations</button></a>

                </span>

            </div>

            <!-- Todos los divs con mensajes (área de mensajes) -->
            <div class="row border border-2 border-dark p-2 messagesArea" name="messagesArea">

                <div class="col align-items-start">

                    <?php foreach ($total as $message) { ?>

                        <?php if ($message->getSender() == $_SESSION["id"]) { ?>

                            <div>

                                <!-- MENSAJES DEL USUARIO -->

                                <!-- DERECHA -->
                                <div class="border border-dark border-1 ps-2 my-2">

                                    <p> <b class="pe-2"><?php echo $meName ?> </b> <?php echo $message->getDate() ?> </p>

                                    <p><?php echo $message->getDescription() ?></p>

                                </div>

                            </div>

                        <?php } else { ?>

                            <!-- MENSAJES DEL OTRO USUARIO -->

                            <!-- IZQUIERDA -->

                            <div class="text-end">

                                <div class="border border-dark border-1 pe-2 my-2">

                                    <p> <?php echo $message->getDate() ?> <b class="ps-2"><?php echo $youName ?></b> </p>

                                    <p><?php echo $message->getDescription() ?></p>

                                </div>

                            </div>

                        <?php } ?>

                    <?php } ?>

                </div>

            </div>

            <!-- Los inputs del user, texto de nuevo mensaje, enviar, etc... -->

            <form class="messageForm" action=<?php echo FRONT_ROOT . "Chat/SendMessage" ?> method="post">

                <div class="row align-items-center userInputs" name="userInputs">

                    <input type="hidden" name="userId" value="<?php echo $idReceiver ?>"></input>

                    <div class="col-9">

                        <textarea class="form-control m-2 messageTextArea" id="newMessage" name="description" rows="4" placeholder="Insert your message"></textarea>

                    </div>

                    <div class="col-3 text-center">

                        <input type="submit" class="btn btn-primary btn-lg" value="Send">

                    </div>

                </div>

            </form>

        </div>
    </div>

</body>

</html>