<?php
require_once __DIR__ . '/includes/data.php';
session_destroy();
header('Location: index.php');
exit;
