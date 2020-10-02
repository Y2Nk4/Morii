var zooming = new Zooming();
zooming.listen('[class*=\'wp-image-\']')
//new Zooming().listen('.post_img')

$(document).ready(function () {
    /* Display EXIF */
    $('div.img-exif-control').click(function () {
        if ($(this.parentNode).find('.img-exif').hasClass('show')) {
            //showing
            $(this.parentNode).find('.img-exif').removeClass('show')
            $(this.parentNode).find('.img-exif').mouseleave()
            $(this.parentNode).find('.img-exif').addClass('not_show')
        } else {
            $(this.parentNode).find('.img-exif').addClass('show')
        }
    })
    $('div.img-exif').click(function () {
        if ($(this).css('opacity') == 0) {
            zooming.open($(this).parent().find('img')[0])
        }
    })
    $('div.post_img').hover(function () {
        console.log('hover', $(this).find('.img-exif'), $(this).find('.img-exif').hasClass('not_show'));
        if ($(this).find('.img-exif').hasClass('not_show')) {
            $(this).find('.img-exif').removeClass('not_show')
        }
    })
    $('div.post_img').focus(function () {
        console.log('hover', $(this).find('.img-exif'), $(this).find('.img-exif').hasClass('not_show'));
        if ($(this).find('.img-exif').hasClass('not_show')) {
            $(this).find('.img-exif').removeClass('not_show')
        }
    })

    /* Day/Night Switch Control */
    let date = new Date(),
        hour = date.getHours()

    const EXPIRE_TIME = 24 * 60 * 60 * 1000

    let storedMode = localStorage.getItem('daynight-mode'),
        switchedAt = localStorage.getItem('switched-at')

    if (storedMode !== null && switchedAt !== null && parseInt(switchedAt) + EXPIRE_TIME > Date.now()) {
        if (storedMode == 1) {
            switchDay()
        } else {
            switchNight()
        }
    } else {
        // default
        if (hour > 20 || hour < 6) {
            console.log('Good Night!')
            switchNight()
        } else {
            switchDay()
        }
    }

    $('#toggle--daynight').click(function () {
        console.log(this, $(this).prop("checked"))

        if ($(this).prop("checked")) {
            // force day-mode
            switchDay()
        } else {
            switchNight()
        }
    })
})

function switchNight () {
    $('body, p, span, h1, a, hr.article-split-line').addClass('night')
    $('#toggle--daynight').prop("checked", false)
    localStorage.setItem('daynight-mode', 2) // night
    localStorage.setItem('switched-at', Date.now())
    zooming.config({
        bgColor: '#2c2a2a'
    })
}
function switchDay () {
    $('.night').removeClass('night')
    $('#toggle--daynight').prop("checked", true)
    localStorage.setItem('daynight-mode', 1) // day
    localStorage.setItem('switched-at', Date.now())
    zooming.config({
        bgColor: '#fff'
    })
}
