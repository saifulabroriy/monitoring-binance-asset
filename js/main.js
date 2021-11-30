// Fungsi untun menampilkan aset ke website
function getMarkets(state = false) {
    // Mendapatkan url page active
    href = $(".page--active").attr("href")

    // Http Request get ke href
    $.get(href, {state}, function(data, status){
        // Isi tabel
        $(".table__body").html(data)
    });
}

// bot telegram element
const startBot = $(".tele__btn--start")
const stopBot =  $(".tele__btn--stop")
const teleDetail = $(".tele__detail")

// Start Bot Telegram
startBot.click(function() {
    $(this).addClass("tele__btn--clicked")
    stopBot.removeClass("tele__btn--clicked")
    teleDetail.html("Bot sedang memantau harga")
})

// Stop Bot Telegram
stopBot.click(function() {
    $(this).addClass("tele__btn--clicked")
    startBot.removeClass("tele__btn--clicked")
    teleDetail.html("Bot tidak mengirimkan pesan")
})

// Price awal
getMarkets()

// Interval tergantung user
setInterval(() => {
    if (startBot.hasClass("tele__btn--clicked")){
        getMarkets(true)
    } else if (stopBot.hasClass("tele__btn--clicked")) {
        getMarkets()
    }
}, 10000);

// Prevent link reload halaman
$( ".page" ).click(function(e) {
    e.preventDefault();

    if (!$(this).hasClass("page--active")) {
        $(".page--active").removeClass("page--active")
        $(this).addClass("page--active")

        if (startBot.hasClass("tele__btn--clicked")){
            getMarkets(true)
        } else if (stopBot.hasClass("tele__btn--clicked")) {
            getMarkets()
        }

        // href = $(".page--active").attr("href")
        // $.get(href, {state: false}, function(data, status){
        //     // Isi tabel
        //     $(".table__body").html(data)
        // });
    }
});