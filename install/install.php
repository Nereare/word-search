<?php
require "../vendor/autoload.php";
require "../php/meta.php";
session_start();

// Load Monolog
$logger = new \Monolog\Logger(constant("APP_NAME") . "_installer");
$logger->pushHandler(
  new \Monolog\Handler\StreamHandler(
    "../install.log",
    \Monolog\Level::Debug
  )
);
/**
 * Set helper function for log registering
 * @param string  $level    The level of message. Either "debug", "notice", "warning", "error", "critical", "alert", "emergency", or "info"
 * @param string  $msg      The text to register
 * @param array   $context  An array with miscellaneous data to save
 * @param string  $target   The section of Grimoire the log is about (e.g. "chapter", "page")
 * @param string  $action   The action being taken (e.g. "create", "edit", "delete", "access")
 */
function loggy(string $level, string $msg, string $target = "?", string $action = "?", array $context = []): void {
  global $logger;
  // Set context
  $context["target"] = $target;
  $context["action"] = $action;

  // Run appropriate Monolog method
  switch ($level) {
      // Debug message
    case "debug":
      $logger->debug($msg, $context);
      break;
      // Notice message
    case "notice":
      $logger->notice($msg, $context);
      break;
      // Warning message
    case "warning":
      $logger->warning($msg, $context);
      break;
      // Error message
    case "error":
      $logger->error($msg, $context);
      break;
      // Critical message
    case "critical":
      $logger->critical($msg, $context);
      break;
      // Alert message
    case "alert":
      $logger->alert($msg, $context);
      break;
      // Emergency message
    case "emergency":
      $logger->emergency($msg, $context);
      break;
      // Info message
    default:
      $logger->info($msg, $context);
      break;
  }
}

// Check if all fields were sent
if (isset($_GET["instance_name"]) &&
    isset($_GET["instance_production"]) &&
    isset($_GET["instance_uri"]) &&
    isset($_GET["instance_protocol"]) &&
    isset($_GET["db_name"]) &&
    isset($_GET["db_username"]) &&
    isset($_GET["db_password"]) &&
    isset($_GET["admin_username"]) &&
    isset($_GET["admin_password"]) &&
    isset($_GET["admin_email"]) &&
    isset($_GET["admin_name_prefix"]) &&
    isset($_GET["admin_name_first"]) &&
    isset($_GET["admin_name_last"]) &&
    isset($_GET["admin_name_suffix"])) {
  // If we received everything...
  // Get fields
  $instance_name        = $_GET["instance_name"];
  $instance_production  = $_GET["instance_production"];
  $instance_uri         = $_GET["instance_uri"];
  $instance_protocol    = $_GET["instance_protocol"];
  $db_name              = $_GET["db_name"];
  $db_username          = $_GET["db_username"];
  $db_password          = $_GET["db_password"];
  $admin_username       = $_GET["admin_username"];
  $admin_password       = $_GET["admin_password"];
  $admin_email          = $_GET["admin_email"];
  $admin_name_prefix    = $_GET["admin_name_prefix"];
  $admin_name_first     = $_GET["admin_name_first"];
  $admin_name_last      = $_GET["admin_name_last"];
  $admin_name_suffix    = $_GET["admin_name_suffix"];
  loggy("debug", "Fields retrieved", "installer", "field check");

  // Try and connect to database
  try {
    $db = new \PDO(
      "mysql:dbname=" . $db_name . ";host=localhost;charset=utf8mb4",
      $db_username,
      $db_password
    );
  } catch (\PDOException $e) {
    // If the connection fails
    loggy("error", "Install attempt could not connect to database", "installer", "database connection");
    die("500");
  }
  // If connection succesful
  loggy("debug", "Connected to database", "installer", "database connection");

  // Database creation
  $schemas = array_filter(scandir("../schema"), function ($elem) {
    return preg_match(
      "/^[1-9][0-9A-Za-z_]*\.sql$/",
      $elem
    ) ? $elem : false;
  });
  foreach ($schemas as $v) {
    $contents = file_get_contents("../schema/{$v}");
    $contents = rtrim($contents, ";" . PHP_EOL);
    $tables = explode(";", $contents);
    foreach ($tables as $t) {
      $t = trim($t);
      try { $result = $db->exec($t); }
      catch (\Exception $e) {
        loggy("error", "Database threw an error", "installer","database population", ["index" => $k, "query" => $t, "db_error" => $db->errorInfo()]);
        die("500");
      }
      if ( $result === false ) {
        loggy("error", "No rows affected", "installer", "database population", ["index" => $k, "query" => $t]);
        die("500");
      } else {
        loggy("debug", "Created table", "installer", "database population");
      }
    }
  }

  // Create Auth object
  $auth = new \Delight\Auth\Auth($db);
  loggy("debug", "Created Auth object", "installer", "Auth class");
  // And create user
  try {
    $uid = $auth->registerWithUniqueUsername($admin_email, $admin_password, $admin_username);
    // Add SUPER_ADMIN role
    $auth->admin()->addRoleForUserById($uid, \Delight\Auth\Role::SUPER_ADMIN);
  } catch (\Exception $e) {
    loggy("error", "Auth threw an error creating admin user", "installer", "admin creation");
    die("428");
  }
  loggy("debug", "Created admin user", "installer", "admin creation");

  // Create preferences object
  $prefs = new \{{PKG_NAMESPACE}}\Preferences(
    $db,
    $uid,
    $admin_name_prefix,
    $admin_name_first,
    $admin_name_last,
    $admin_name_suffix
  );

  // Create `config.php`
  file_put_contents("../php/config.php", "<?php
// Site instance data
define(\"INSTANCE_TITLE\",        \"{$instance_name}\");
define(\"PRODUCTION\",            {$instance_production});

// Site base link
define(\"SITE_BASEURI\",          \"{$instance_uri}\");
define(\"SITE_PROTOCOL\",         \"{$instance_protocol}\");

// Database connection data
define(\"INSTANCE_DB_NAME\",      \"{$db_name}\");
define(\"INSTANCE_DB_USER\",      \"{$db_username}\");
define(\"INSTANCE_DB_PASSWORD\",  \"{$db_password}\");
", LOCK_EX);
  loggy("debug", "Config file created", "installer", "config file");

  // Finish: exit with zero ("0") status - success
  exit("0");
} else {
  // Die with an error if missing data
  loggy("error", "Install attempt missed some or all fields", "installer", "field check");
  die("428");
}
