<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Files</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/Css/styles.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1">Management Files</span>
  </div>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" aria-current="page" href="/">Home</a>
      </li>
      <?php if ((isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true)) { ?>
      <li class="nav-item">
        <a class="nav-link" aria-current="page" href="/documents">Documents</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/allCategories">Categories</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?=isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Mi cuenta' ?>
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <li><a class="dropdown-item" href="#">Profile</a></li>
          <li><a class="dropdown-item" href="/logout">Logout</a></li>
        </ul>
      </li>
      <?php } else{ ?>
        <li class="nav-item">
        <a class="nav-link" href="/login">Login</a>
      </li>
      <?php } ?>
    </ul>
  </div>
</nav>