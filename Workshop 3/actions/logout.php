<?php
require_once __DIR__ . '/../utils/config.php';
require_once __DIR__ . '/../utils/auth.php';

logoutUser();

header('Location: ' . appUrl('index.php?success=logged_out'));
