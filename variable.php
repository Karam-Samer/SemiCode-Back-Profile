<?php
$errors = [];
$old = [];
$values = ['Name', 'Email', 'Language', 'Password', 'CPassword'];
$regex=array(
    'Name' => '/^[A-Z][A-Za-z\s]+$/',
    'Email' => '/^[A-Za-z]+[A-Za-z0-9\-.]+@(gmail|yahoo|outlook)\.(com|org|net)$/',
    'Language' => '/^(English|French|Spanish)$/',
    'Password' => '/^[\w!@]{8,20}$/',
    'CPassword' => '/^[\w!@]{8,20}$/'
);
$regexError = array(
    'Name' => '* Name must contain only letters and spaces',
    'Email' => '* Email must be a valid email address (gmail, yahoo, outlook)',
    'Language' => '* Language must be either English, French, or Spanish',
    'Password' => '* Password must be 8-20 characters',
    'CPassword' => '* Confirm Password must identical to Password'
);
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
