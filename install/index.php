<?php
require "../vendor/autoload.php";
require "../php/meta.php";
session_start();
?>
<!DOCTYPE html>
<html lang="pt_BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="apple-touch-icon" sizes="180x180" href="../favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="194x194" href="../favicon/favicon-194x194.png">
  <link rel="icon" type="image/png" sizes="192x192" href="../favicon/android-chrome-192x192.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../favicon/favicon-16x16.png">
  <link rel="manifest" href="../favicon/site.webmanifest">
  <link rel="mask-icon" href="../favicon/safari-pinned-tab.svg" color="#922610">
  <link rel="shortcut icon" href="../favicon/favicon.ico">
  <meta name="msapplication-TileColor" content="#922610">
  <meta name="msapplication-TileImage" content="../favicon/mstile-144x144.png">
  <meta name="msapplication-config" content="../favicon/browserconfig.xml">
  <meta name="theme-color" content="#922610">

  <title><?php echo constant("APP_NAME"); ?></title>

  <link rel="stylesheet" href="../node_modules/@mdi/font/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../node_modules/@creativebulma/bulma-tagsinput/dist/css/bulma-tagsinput.min.css">
  <link rel="stylesheet" href="../node_modules/typeface-montserrat/index.css">
  <link rel="stylesheet" href="../node_modules/typeface-roboto-mono/index.css">
  <link rel="stylesheet" href="../style/style.css">

  <script type="text/javascript" src="../node_modules/jquery/dist/jquery.min.js" charset="utf-8"></script>
  <script type="text/javascript" src="../node_modules/@creativebulma/bulma-tagsinput/dist/js/bulma-tagsinput.min.js" charset="utf-8"></script>
  <script type="text/javascript" src="../js/common.js" charset="utf-8"></script>
  <script type="text/javascript" src="install.js" charset="utf-8"></script>
</head>

<body>

  <header class="hero is-primary">
    <div class="hero-body has-text-centered">
      <p class="title">
        <?php echo constant("APP_NAME"); ?>
      </p>
      <p class="subtitle">
        Installer
      </p>
    </div>
  </header>

  <main class="section">
    <form class="container" id="install-form">
      <div class="box">
        <h2 class="title is-4">
          <span class="icon-text">
            <span class="icon mr-4">
              <i class="mdi mdi-auto-fix mdi-36px"></i>
            </span>
            <span>Installation Wizard</span>
          </span>
        </h2>

        <div class="content">
          <p>
            Welcome to the <strong><?php echo constant("APP_NAME"); ?></strong>
            installer.
          </p>
          <p>
            This wizard will guide you through the installation process. We
            advise you to take this moment to fetch your database login
            information, which will be needed for a successful setup.
          </p>
          <p>
            Note that this project is available under the
            <a href="<?php echo constant("APP_LICENSE_URI"); ?>">
              <?php echo constant("APP_LICENSE_NAME"); ?>
            </a>.
          </p>
          <p>
            You can read further about this project, as well as ask questions
            and make requests, at our
            <a href="<?php echo constant("APP_REPO"); ?>">repository</a>.
          </p>
        </div>

        <div class="notification is-warning is-light">
          <p>
            All fields whose label has an asterisk (<code>*</code>) are
            required!
            Failing to fill these will stop the installation logic short.
          </p>
        </div>

        <div>
          <div class="divider">&bull;&nbsp;&bull;&nbsp;&bull;</div>
        </div>

        <h3 class="title is-5">
          <span class="icon-text">
            <span class="icon mr-3">
              <i class="mdi mdi-application mdi-24px"></i>
            </span>
            <span>Instance</span>
          </span>
        </h3>
        <p class="subtitle is-6">Setting up the instance's data</p>

        <div class="field">
          <div class="control has-icons-left">
            <input type="text" class="input is-large" id="instance-name" placeholder="Instance name*" required>
            <span class="icon is-large is-left">
              <i class="mdi mdi-head"></i>
            </span>
          </div>
        </div>

        <div class="field">
          <div class="control has-text-centered">
            <input type="checkbox" class="switch is-success is-medium" id="instance-production" checked>
            <label for="instance-production">Production-ready*</label>
          </div>
        </div>

        <div class="field">
          <div class="control has-icons-left">
            <input type="text" class="input" id="instance-uri" placeholder="Base URI*" required>
            <span class="icon is-left">
              <i class="mdi mdi-link"></i>
            </span>
          </div>
        </div>

        <div class="field">
          <div class="control has-icons-left is-expanded">
            <div class="select is-fullwidth">
              <select id="instance-protocol" required>
                <option value="" selected disabled>URI Protocol*</option>
                <option value="https">Safe</option>
                <option value="http">Unsafe</option>
              </select>
            </div>
            <span class="icon is-left">
              <i class="mdi mdi-protocol"></i>
            </span>
          </div>
        </div>

        <div>
          <div class="divider">&bull;&nbsp;&bull;&nbsp;&bull;</div>
        </div>

        <h3 class="title is-5">
          <span class="icon-text">
            <span class="icon mr-3">
              <i class="mdi mdi-database mdi-24px"></i>
            </span>
            <span>Database</span>
          </span>
        </h3>
        <p class="subtitle is-6">Setting up the database for the project</p>

        <div class="notification is-info is-light">
          <p>
            Before installing this application, create a database and correlated
            user for it under your domain's Control Panel.
          </p>
          <p>
            Take note of the dabase's <code>name</code>, and user's
            <code>username</code> and <code>password</code>. These will be requested
            below.
          </p>
          <p>
            Please note that this project uses <a href="https://www.mysql.com/">MySQL</a>
            as its database system.
          </p>
        </div>

        <div class="field">
          <div class="control has-icons-left">
            <input type="text" class="input" id="db-name" placeholder="Name*" required>
            <span class="icon is-left">
              <i class="mdi mdi-database"></i>
            </span>
          </div>
        </div>

        <div class="field">
          <div class="control has-icons-left">
            <input type="text" class="input" id="db-username" placeholder="Username*" required>
            <span class="icon is-left">
              <i class="mdi mdi-database-cog"></i>
            </span>
          </div>
        </div>

        <div class="field">
          <div class="control has-icons-left">
            <input type="password" class="input" id="db-password" placeholder="Password*" required>
            <span class="icon is-left">
              <i class="mdi mdi-database-lock"></i>
            </span>
          </div>
        </div>

        <div>
          <div class="divider">&bull;&nbsp;&bull;&nbsp;&bull;</div>
        </div>

        <h3 class="title is-5">
          <span class="icon-text">
            <span class="icon mr-3">
              <i class="mdi mdi-account-circle mdi-24px"></i>
            </span>
            <span>Admin</span>
          </span>
        </h3>
        <p class="subtitle is-6">
          The information below regards your user in the app itself.
          This user will have the <code>ADMIN</code> privilege.
        </p>

        <p class="help">
          The username, once set, cannot be changed! And it can contain
          only alphanumeric characters and underlines (<code>_</code>),
          it must start with a letter (<code>A-Z|a-z</code>), and have
          at least 6 characters.
        </p>
        <div class="field">
          <div class="control has-icons-left">
            <input type="text" class="input" id="admin-username" placeholder="Username*" required>
            <span class="icon is-left">
              <i class="mdi mdi-account"></i>
            </span>
          </div>
        </div>

        <p class="help">
          The password can contain alphanumeric characters as well as
          some special symbols (<code>_-?$()#@.=</code>), it also must
          be at least 6 character long.
        </p>
        <div class="field">
          <div class="control has-icons-left">
            <input type="password" class="input" id="admin-password" placeholder="Password*" required>
            <span class="icon is-left">
              <i class="mdi mdi-lock"></i>
            </span>
          </div>
        </div>

        <div class="field">
          <div class="control has-icons-left">
            <input type="email" class="input" id="admin-email" placeholder="Email*" required>
            <span class="icon is-left">
              <i class="mdi mdi-email"></i>
            </span>
          </div>
        </div>

        <div class="field has-addons">
          <div class="control">
            <div class="select">
              <select id="admin-name-prefix">
                <option value="" selected>No prefix</option>
                <option value="Mx.">Mx.</option>
                <option value="Mr.">Mr.</option>
                <option value="Ms.">Ms.</option>
                <option value="Miss">Miss</option>
                <option value="Nb.">Nb.</option>
                <option value="Ind.">Ind.</option>
                <option value="Sir">Sir</option>
                <option value="Mme.">Mme.</option>
                <option value="Mlle.">Mlle.</option>
                <option value="Dame">Dame</option>
                <option value="Lady">Lady</option>
                <option value="Lord">Lord</option>
                <option value="Esq.">Esq.</option>
                <option value="H.E.">H.E.</option>
                <option value="Hon.">Hon.</option>
                <option value="Rt Hon.">Rt Hon.</option>
                <option value="Mt Hon.">Mt Hon.</option>
                <option value="Dr.">Dr.</option>
                <option value="Prof.">Prof.</option>
              </select>
            </div>
          </div>
          <div class="control has-icons-left">
            <input type="text" class="input" id="admin-name-first" placeholder="First Name">
            <span class="icon is-left">
              <i class="mdi mdi-card-account-details"></i>
            </span>
          </div>
          <div class="control is-expanded">
            <input type="text" class="input" id="admin-name-last" placeholder="Last Name">
          </div>
          <div class="control is-expanded">
            <input type="text" class="input" id="admin-name-suffix" placeholder="Suffix">
          </div>
        </div>
      </div>

      <div class="box">
        <div class="field">
          <div class="control is-expanded">
            <button type="submit" class="button is-success is-fullwidth">
              <span class="icon-text">
                <span class="icon">
                  <i class="mdi mdi-content-save"></i>
                </span>
                <span>Install</span>
              </span>
            </button>
          </div>
        </div>
      </div>
    </form>
  </main>

  <footer class="footer pt-3 pb-4">
    <div class="content has-text-centered">
      <p class="mb-2">
        <strong><?php echo constant("APP_NAME"); ?></strong>
      </p>
      <p class="is-size-7">
        <a href="<?php echo constant("APP_REPO"); ?>">
          <?php echo constant("APP_NAME"); ?>
        </a>
        &copy;
        <?php echo constant("APP_YEAR"); ?>
        <?php echo constant("APP_AUTHOR"); ?>
        &bull;
        Available under the
        <a href="<?php echo constant("APP_LICENSE_URI"); ?>">
          <?php echo constant("APP_LICENSE_NAME"); ?>
        </a>
      </p>
    </div>
  </footer>

  <div class="notification is-hidden" id="notification">
    <button class="delete"></button>
    <p>Foo</p>
  </div>

</body>

</html>
