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

<body>

  <div class="row text-center">
    <div class="col-sm mt-5 border-end border-4 border-dark">
      <h1 class="role-title">Guardian<h1>
          <a href=<?php echo FRONT_ROOT . "Auth/ShowRegisterGuardian" ?>><img class="img-fluid role-image mt-3" src="../Views/images/Guardian.png"></a>

    </div>
    <div class="col-sm mt-5">

      <h1 class="role-title">Pet Owner</h1>
      <a href=<?php echo FRONT_ROOT . "Auth/ShowRegisterOwner" ?>><img class="img-fluid role-image mt-3" src="../Views/images/Pet_Owner.png"></a>


    </div>
  </div>
  <div class="row">

    <div class="col text-center">

      <div class="container align-items-center border border-dark chooseYourSide">

        <b class="f1"> CHOOSE YOUR SIDE</b>

      </div>

    </div>

  </div>

</body>

</html>