<?php
    // Include file module telegram 
    include_once "telegram.php";

    // Mendapatkan state bot telegram
    $state = $_GET["state"];
    $limit = $_GET["limit"];

    // Fungsi mendapatkan data di return menjadi JSON dari URL
    function getData($url){
        // persiapkan curl
        $curl = curl_init(); 

        // Set Opsi pada curl
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 

        // eksekusi dan dimasukkan ke markets
        $res = curl_exec($curl); 

        // Error Handler
        if (curl_errno($curl)) {
            print "Error: " . curl_error($curl);
        } else {
            // Tutup curl
            curl_close($curl);

            return json_decode($res);
        }
    }

    // Mendapatkan symbols
    $url = "https://api.binance.me/api/v3/exchangeInfo";
    $ex_infos = getData($url);
    $symbols = $ex_infos->symbols;

    // Mendapatkan data ticker
    $url = "https://api.binance.me/api/v3/ticker/24hr";
    $ticker = getData($url);

    if ($limit == "Tampilkan Semua") {
        $limit = count($ticker);
    }

    // Jika page tidak diisi maka page = 1
    $page = !isset($_GET['page']) ? 1 : $_GET['page'];

    // posisi atau cursor
    $offset = ($page - 1) * $limit;

    // potong array asli menjadi array yang dilimit
    $limited_symbols = array_splice($symbols, $offset, $limit); // splice them according to offset and limit
    $limited_ticker = array_splice($ticker, $offset, $limit); // splice them according to offset and limit

    // array untuk tempat aset lowest dan highest
    $low_asset = array();
    $high_asset = array();

    // Cek lowest dan highest
    for($i = 0; $i <= count($limited_ticker) - 1; $i++) {
        $koin = $limited_symbols[$i]->baseAsset;
        $pair = $limited_symbols[$i]->quoteAsset;
        $last = $limited_ticker[$i]->lastPrice;
        $low = $limited_ticker[$i]->lowPrice;
        $high = $limited_ticker[$i]->highPrice;
        $lowest = $last - $low;
        $highest = $high - $last;

        // Cek price
        if($lowest <= 0){
            array_push($low_asset, "$koin/$pair");
        }

        if($highest <= 0){
            array_push($high_asset, "$koin/$pair");
        }
    }
    
    $num = $offset + 1;
    for($i = 0; $i <= count($limited_ticker) - 1; $i++) {
        // membongkar menjadi beberapa variable agar mudah
        $koin = $limited_symbols[$i]->baseAsset;
        $pair = $limited_symbols[$i]->quoteAsset;
        $last = $limited_ticker[$i]->lastPrice;
        $low = $limited_ticker[$i]->lowPrice;
        $high = $limited_ticker[$i]->highPrice;
        $last_formatted = number_format($last, 3, ",", ".");
        $low_formatted = number_format($low, 3, ",", ".");
        $high_formatted = number_format($high, 3, ",", ".");
        $lowest = number_format($last - $low, 3, ",", ".");
        $highest = number_format($high - $last, 3, ",", ".");

        // Membuat baris tabel
        echo "<tr class=\"table__row\">";
        echo "<td class=\"table__item table__item--number\">$num</td>";
        echo "<td class=\"table__item table__item--coin\">$koin</td>";
        echo "<td class=\"table__item table__item--pair\">$pair</td>";
        echo "<td class=\"table__item table__item--last\">$last_formatted</td>";
        echo "<td class=\"table__item table__item--low\">$low_formatted</td>";
        echo "<td class=\"table__item table__item--high\">$high_formatted</td>";
        echo "<td class=\"table__item table__item--lowest\">$lowest</td>";
        echo "<td class=\"table__item table__item--highest\">$highest</td>";
        echo "</tr>";

        $num++;
    }

    // Jika state yang dikirim true
    if ($state == "true"){
        // Mendapatkan timestamp dari mikrotime bingbon
        $waktu = round($ex_infos->serverTime / 1000 );

        $msg = "Waktu Server: " . date('j M Y, H:i:s', $waktu) . " %0a%0a";

        // Jika array low ada isinya
        if (count($low_asset) > 0){
            $msg .= "LOW %0a%0a";
            for ($i=0; $i < count($low_asset); $i++) { 
                $msg .= $i + 1 . ". " . $low_asset[$i] . " %0a";
            }
            $msg .= "%0a";
        }
        
        // Jika array high ada isinya
        if (count($high_asset) > 0){
            $msg .= "HIGH %0a%0a";
            for ($i=0; $i < count($high_asset); $i++) { 
                $msg .= $i + 1 . ". " . $high_asset[$i] . " %0a";
            }
        }

        // Jika salah satu dari array low dan high ada isinya maka kirim pesan
        if (count($high_asset) > 0 || count($low_asset) > 0){
            sendMessage($msg);
        }
    }