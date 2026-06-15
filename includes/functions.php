<?php

$users = [
    [
        "username" => "admin",
        "password" => "admin123",
        "status" => "authorized"
    ]
];

function cleanInput($value) {
    return htmlspecialchars(strip_tags(trim($value)));
}