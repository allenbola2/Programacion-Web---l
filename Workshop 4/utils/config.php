<?php
const BASE_URL = '/Programacion-Web-I/Workshop%204';
function appUrl(string $path = ''): string
{
    return BASE_URL . '/' . ltrim($path, '/');
}
