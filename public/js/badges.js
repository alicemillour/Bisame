$(function () {
    if ($('#badgeModal').length > 0) {
        $('#badgeModal').modal('show');
        $('#badgeModal').on('shown.bs.modal', function (e) {
            setTimeout(function () {
                $('#badgeModal').modal('hide');
            }, 5000);
        })
    }
})