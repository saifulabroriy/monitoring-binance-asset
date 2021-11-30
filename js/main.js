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

// Slider
const sliderTab = $(".slider__tab")
const sliderValue = $(".slider__value")

// nilai detik
let timer = sliderTab.val()

// Show initial value of slider
sliderValue.html(timer)

// Update value
sliderTab.on('input', function () {
    timer = sliderTab.val()
    sliderValue.html(timer)
})

sliderTab.on('mousemove', function () {
    const color = `linear-gradient(to right, #1cb81c ${((timer - 10) * 100) / (60 - 10)}%, #fff ${((timer - 10) * 100) / (60 - 10)}%)`
    $(this).css("background", color)
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
}, timer * 1000);

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
    }
});