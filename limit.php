<?php
    // Mendapatkan prices
    $prices = json_decode(file_get_contents('https://api.binance.me/api/v3/ticker/price'));

    // menentukan limit
    $limit = !isset($_GET['limit']) ? 25 : $_GET['limit'];

    if ($limit == "Tampilkan Semua") {
        echo "<option>1</option>";
    } else {
        // Menghitung jumlah aset dan jumlah halaman
        $total_items = count($prices);
        $total_pages = ceil($total_items / $limit);

        // Menampilkan option
        for($x = 1; $x <= $total_pages; $x++) {
            echo "<option>$x</option>";
        }
    }