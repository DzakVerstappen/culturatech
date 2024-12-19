<?php
  session_start();

  require_once _DIR_ . '/../src/Database.php';

  try {
      $database = new Database();
      $db = $database->getConnection();
  } catch(Exception $e) {
      die("Connection failed: Please try again later.");
  }
?>