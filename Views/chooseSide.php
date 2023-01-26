<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
  <link href="../Views/css/chooseSide.css" rel="stylesheet">
  <title>Register Side</title>
</head>

<body style="height: 100vh">

  <div class="container w-auto">

    <div class="row py-5">

      <div class="col">

        <div class="row text-center mt-2">

          <div class="col-sm-6 border-end border-4 border-dark">
            <h1 class="role-title">Guardian<h1>
                <a href=<?php echo FRONT_ROOT . "Auth/ShowRegisterGuardian" ?>><img class="role-image" src="../Views/images/Guardian.png"></a>

          </div>

          <div class="col-sm-6">

            <h1 class="role-title">Pet Owner</h1>
            <a href=<?php echo FRONT_ROOT . "Auth/ShowRegisterOwner" ?>><img class="role-image" src="../Views/images/Pet_Owner.png"></a>

          </div>

        </div>

        <div class="row text-center">

          <div class="align-items-center border border-dark chooseYourSide mt-2">

            <b> CHOOSE YOUR SIDE</b>

          </div>

        </div>

      </div>

    </div>

  </div>

</body>

</html>