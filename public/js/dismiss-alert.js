$(function() {
    var alerts = $(".alert")
    if(alerts.length) {
        setTimeout(function() {
            alerts.fadeOut(function() {
                $(this).remove()
            })
        }, 3000)
    }
})