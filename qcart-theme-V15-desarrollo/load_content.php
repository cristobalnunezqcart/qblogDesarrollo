<?php
// Simulando la carga de más contenido desde el servidor

$page = isset($_GET['page_no']) ? $_GET['page_no'] : 1;
$itemsPerPage = isset($_GET['items_per_page']) ? $_GET['items_per_page'] : 6;

// Aquí puedes realizar una consulta a la base de datos o cargar contenido de alguna manera
// En este ejemplo, simplemente estamos devolviendo un fragmento de HTML con números incrementales

$html = '';
for ($i = 1; $i <= $itemsPerPage; $i++) {
    $contentNumber = ($page - 1) * $itemsPerPage + $i;
    $html .= '<div class="content">' . $contentNumber . '</div>';
}

echo $html;
?>
