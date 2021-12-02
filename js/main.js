// Fungsi untun menampilkan aset ke website
function getMarkets(page = 1, limit = 25, state = false) {
    // Http Request get ke href
    $.get(`binance.php?page=${page}`, {state, limit}, function(data, status){
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
    const page = $(".dropdown__page option:selected").html()
    const limit = $(".dropdown__limit option:selected").html()

    if (startBot.hasClass("tele__btn--clicked")){
        getMarkets(page, limit, true)
    } else if (stopBot.hasClass("tele__btn--clicked")) {
        getMarkets(page, limit)
    }
}, timer * 1000);

$(".dropdown__page").on("change", function () {
    const page = $(".dropdown__page option:selected").html()
    const limit = $(".dropdown__limit option:selected").html()

    if (startBot.hasClass("tele__btn--clicked")){
        getMarkets(page, limit, true)
    } else if (stopBot.hasClass("tele__btn--clicked")) {
        getMarkets(page, limit)
    }
})

$(".dropdown__limit").on("change", function () {
    const limit = $(".dropdown__limit option:selected").html()

    $.get('limit.php', {limit}, function (data, status) {
        $(".dropdown__page").html(data)
    })

    if (startBot.hasClass("tele__btn--clicked")){
        getMarkets(1, limit, true)
    } else if (stopBot.hasClass("tele__btn--clicked")) {
        getMarkets(1, limit)
    }
})