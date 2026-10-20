<?php
// URL base del Workshop 3 en XAMPP.
const BASE_URL = '/Programacion-Web-I/Workshop%203';

// Genera enlaces internos consistentes.
function appUrl(string $path = ''): string
{
    return BASE_URL . '/' . ltrim($path, '/');
}
