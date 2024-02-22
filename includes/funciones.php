<?php

function debuguear($variable): string
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html): string
{
    $s = htmlspecialchars($html);
    return $s;
}
function isUltimo($actual, $proximo): bool
{
    if ($actual != $proximo) {
        return true;
    }
    return false;
}
function  isAuth(): void
{

    if (!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

function isAdmin(): void
{
    if ($_SESSION['admin'] != '1') {
        if (!isset($_SESSION['login'])) {
            header('Location: /');
        }
        else{
            header('Location: /citas');
        }
    }
}
