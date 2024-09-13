<?php
require "common.php";

// Check if there are the required indexes
if (!isset($_GET["username"]) ||
    !isset($_GET["password"]) ||
    !isset($_GET["remember"])) {
  loggy("warning", "Request does not offer the minimum required fields", "login", "login");
  die("1");
}
// Get sent data
$username = $_GET["username"];
$password = $_GET["password"];
$remember = isset($_GET["remember"]) ? 60*60*24*30*3 : null;
// And check them not to be empty
if (strlen($username) < 1 || strlen($password) < 1) {
  loggy("warning", "Request does not offer the minimum required fields", "login", "login");
  die("1");
}

try {
  $auth->loginWithUsername(
    $username,
    $password,
    $remember
  );
  loggy("debug", "User logged in", "login", "login");
  echo "0";
} catch (\Exception $e) {
  loggy("warning", "Failed login attempt", "login", "login");
  die("1");
}
