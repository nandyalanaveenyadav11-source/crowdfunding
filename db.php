<?php
$pdo = new PDO('mysql:host=localhost', 'root', '');
$pdo->exec('CREATE DATABASE IF NOT EXISTS crowdfunding;');
echo "Database created successfully.\n";
