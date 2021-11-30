<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Monitoring Binance (PHP)</title>
    <link rel="stylesheet" href="css/main.css" />
    <script src="js/jquery.js"></script>
  </head>
  <body>
    <!-- Header -->
    <header class="header">
      <h1 class="header__title">Monitoring Binance (PHP)</h1>
    </header>
    <!-- Akhir Header -->

    <!-- Main -->
    <main class="content">
      <section class="tele">
        <h2 class="tele__title">Bot Telegram</h2>
        <div class="tele__setting">
          <button class="tele__btn tele__btn--start">Start Bot</button>
          <button class="tele__btn tele__btn--stop tele__btn--clicked">Stop Bot</button>
        </div>
        <p class="tele__detail">Bot tidak mengirimkan pesan</p>
      </section>
      <section class="tool">
        <h2 class="tool__title">Marketplace Binance</h2>
        <?php 
          $prices = json_decode(file_get_contents('https://api.binance.me/api/v3/ticker/price'));

          // limit 100 per halaman
          $limit = 100;
          $total_items = count($prices); // total items
          $total_pages = ceil($total_items / $limit);

          for($x = 1; $x <= $total_pages; $x++):
            if ($x == 1) {
              echo "<a class=\"page page--active\" href=\"binance.php?page=$x\">$x</a>";
            } else {
              echo "<a class=\"page\" href=\"binance.php?page=$x\">$x</a>";
            }
          endfor;
        ?>
      </section>
      <section class="table">
        <table>
          <thead>
            <tr class="table__header__row">
              <th class="table__header table__header--number">No.</th>
              <th class="table__header table__header--coin">Koin</th>
              <th class="table__header table__header--pair">Pair</th>
              <th class="table__header table__header--last">Last</th>
              <th class="table__header table__header--low">Low</th>
              <th class="table__header table__header--high">High</th>
              <th class="table__header table__header--lowest">Is Lowest?</th>
              <th class="table__header table__header--highest">Is Highest?</th>
            </tr>
          </thead>
          <tbody class="table__body">
            
          </tbody>
        </table>
      </section>
    </main>
    <!-- Akhir Main -->

    <!-- Footer -->
    <footer class="footer">
      <p class="footer__text">Created by Kelompok 13 API 2021</p>
    </footer>
    <!-- Akhir Footer -->

    <script src="js/main.js"></script>
  </body>
</html>
