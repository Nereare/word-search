<?php
require "vendor/autoload.php";
require "php/meta.php";
session_start();

// Try and reach the configuration file
if (is_readable("php/config.php")) {
  // Include configuration file
  require_once("php/config.php");

  if (constant("PRODUCTION") && is_readable("install/")) {
    $installed = false;
  } else {
    $installed = true;
  }

  // Set title
  $title = constant("INSTANCE_TITLE");

  // Try and connect to the database
  try {
    $db = new \PDO(
      "mysql:dbname=" . constant("INSTANCE_DB_NAME") . ";host=localhost;charset=utf8mb4",
      constant("INSTANCE_DB_USER"),
      constant("INSTANCE_DB_PASSWORD")
    );
    $installed = true;
  } catch (\Exception $e) {
    $installed = false;
  }
} else {
  $installed = false;
  $title = "Adventure";
}

// Load Auth only if installed
if (isset($installed) && $installed) {
  $auth = new \Delight\Auth\Auth($db);
}
?>
<!DOCTYPE html>
<html lang="pt_BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="194x194" href="favicon/favicon-194x194.png">
  <link rel="icon" type="image/png" sizes="192x192" href="favicon/android-chrome-192x192.png">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
  <link rel="manifest" href="favicon/site.webmanifest">
  <link rel="mask-icon" href="favicon/safari-pinned-tab.svg" color="#922610">
  <link rel="shortcut icon" href="favicon/favicon.ico">
  <meta name="msapplication-TileColor" content="#922610">
  <meta name="msapplication-TileImage" content="favicon/mstile-144x144.png">
  <meta name="msapplication-config" content="favicon/browserconfig.xml">
  <meta name="theme-color" content="#922610">

  <title><?php echo $title; ?></title>

  <link rel="stylesheet" href="node_modules/@mdi/font/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="node_modules/@creativebulma/bulma-tagsinput/dist/css/bulma-tagsinput.min.css">
  <link rel="stylesheet" href="node_modules/typeface-montserrat/index.css">
  <link rel="stylesheet" href="node_modules/typeface-roboto-mono/index.css">
  <link rel="stylesheet" href="style/style.css">

  <script type="text/javascript" src="node_modules/jquery/dist/jquery.min.js" charset="utf-8"></script>
  <script type="text/javascript" src="node_modules/@creativebulma/bulma-tagsinput/dist/js/bulma-tagsinput.min.js" charset="utf-8"></script>
  <script type="text/javascript" src="js/common.js" charset="utf-8"></script>
</head>

<body>
  <?php
  if (!$installed) { // If the instance is not installed:
  ?>
    <section class="hero is-primary is-fullheight">
      <div class="hero-body">
        <div class="container">
          <div class="columns mb-0 is-centered">
            <div class="column is-6">
              <div class="box">
                <div class="has-text-centered">
                  <figure class="image is-128x128 is-inline-block">
                    <img src="assets/404.png">
                  </figure>
                </div>

                <h2 class="title is-4">
                  <span class="icon-text has-text-primary">
                    <span class="icon">
                      <i class="mdi mdi-alert-circle"></i>
                    </span>
                    <span>Oopsie...</span>
                  </span>
                </h2>

                <div class="content">
                  <p>
                    The site doesn't seem to be properly installed. Contact the domain admnistrator for help with this issue.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php
    exit(0);
  } elseif (!$auth->isLoggedIn()) { // If the user is NOT logged in
  ?>
    <section class="hero is-primary is-fullheight">
      <div class="hero-body">
        <div class="container">
          <div class="columns mb-0 is-centered">
            <div class="column is-6">
              <div class="box">
                <div class="has-text-centered">
                  <figure class="image is-128x128 is-inline-block">
                    <img src="assets/Icon.png">
                  </figure>
                </div>

                <form class="content" id="login">
                  <div class="field">
                    <p class="control has-icons-left">
                      <input type="text" class="input" id="login-username" placeholder="Username">
                      <span class="icon is-small is-left">
                        <i class="mdi mdi-account mdi-24px"></i>
                      </span>
                    </p>
                  </div>

                  <div class="field">
                    <p class="control has-icons-left">
                      <input type="password" class="input" id="login-password" placeholder="Password">
                      <span class="icon is-small is-left">
                        <i class="mdi mdi-lock mdi-24px"></i>
                      </span>
                    </p>
                  </div>

                  <div class="field">
                    <div class="control">
                      <input type="checkbox" class="is-checkradio" id="login-persistent" checked>
                      <label for="login-persistent">Remember Me?</label>
                    </div>
                  </div>

                  <div class="field">
                    <p class="control is-expanded">
                      <button type="submit" class="button is-primary is-fullwidth" id="login-login">
                        <span class="icon-text">
                          <span class="icon">
                            <i class="mdi mdi-login"></i>
                          </span>
                          <span>Login</span>
                        </span>
                      </button>
                    </p>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php
    exit(0);
  } else { // If the user IS logged in
  ?>
    <!------------------------------------->
    <!--              MENU               -->
    <!------------------------------------->
    <header class="navbar is-primary">
      <div class="navbar-brand">
        <a class="navbar-item" href="<?php echo constant("SITE_PROTOCOL"); ?>://<?php echo constant("SITE_BASEURI"); ?>">
          <img src="assets/Icon White.png">
        </a>

        <a class="navbar-burger">
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
        </a>
      </div>

      <div class="navbar-menu">
        <div class="navbar-end">
          <!-- Config -->
          <a class="navbar-item" href="cp.php">
            <span class="icon">
              <i class="mdi mdi-cog"></i>
            </span>
            <span>Config</span>
          </a>
          <!-- Logout -->
          <a class="navbar-item" id="logout">
            <span class="icon">
              <i class="mdi mdi-logout-variant"></i>
            </span>
            <span>Logout</span>
          </a>
        </div>
      </div>
    </header>
  <?php
  }
