<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

    <title>Chat</title>
</head>

<body>

    <div class="container vh-100 h-100 p-3" name="maximum">
        <div class="border border-2 border-dark h-100 p-4" name="chat">

            <!-- Mensajes de volver, Perfil del Guardian y ver Reservas -->
            <div class="row" name="upperButtons" style="height: 10%">

            </div>

            <!-- Todos los divs con mensajes (área de mensajes) -->
            <div class="row border border-2 border-dark p-2" name="messagesArea" style="height: 70%; overflow-y: scroll; display: flex; flex-direction: column-reverse;">

                <div class="col align-items-start">

                    <?php foreach ($total as $message) { ?>

                        <?php if ($message->getSender() == $_SESSION["id"]) { ?>

                            <div>

                                <!-- DERECHA -->
                                <div class="border border-dark border-1 ps-2 my-2">


                                    <p> <b>Sender: <?php echo $message->getSender(); ?> </b> <?php echo "Date: " . $message->getDate() ?> </p>

                                    <p><?php echo $message->getDescription() ?></p>

                                </div>

                            </div>

                        <?php } else { ?>

                            <!-- IZQUIERDA -->

                            <div class="text-end">

                                <div class="border border-dark border-1 pe-2 my-2">

                                    <p> <?php echo "Date: " . $message->getDate() ?> <b>Sender: <?php echo $message->getSender(); ?></b> </p>

                                    <p><?php echo $message->getDescription() ?></p>

                                </div>

                            </div>

                        <?php } ?>

                    <?php } ?>

                </div>

            </div>

            <!-- Los inputs del user, texto de nuevo mensaje, enviar, etc... -->

            <form action=<?php echo FRONT_ROOT . "Chat/SendMessage" ?> method="post">

                <div class="row align-items-center my-3" name="userInputs" style="height: 20%">


                    <input type="hidden" name="userId" value="<?php echo $idReceiver ?>"></input>

                    <div class="col-9">

                        <textarea class="form-control m-2" id="newMessage" name="description" rows="4" style="resize: none" placeholder="Insert your message"></textarea>

                    </div>



                    <div class="col-3 text-center">

                        <input type="submit" class="btn btn-primary btn-lg" value="Send">

                    </div>

            </form>

        </div>

    </div>
    </div>

</body>

</html>