<?php
if (!isset($pageTitle)) { $pageTitle = 'VoiceBrowser'; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <header class="site-header">
    <a class="brand" href="index.html">Voice<span>Browser</span></a>
    <nav aria-label="Main navigation">
      <a href="index.html">Home</a><a href="speak.html">Speak</a><a href="listen.html">Listen</a><a href="about.html">About</a>
    </nav>
  </header>
