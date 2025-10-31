<?php
$url = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if ($url === '') $url = 'home';

$page_file = "pages/$url.php";

if (file_exists($page_file)) {
    $page_content = $page_file;
} else {
    http_response_code(404);
    $page_content = "pages/404.php";
}

include("layout.php");
?>