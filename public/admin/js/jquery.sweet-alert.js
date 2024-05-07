$(function(e) {
    // Delete
    $(".swal-delete").click(function () {
        url = $(this).data("url");
        token = $('meta[name="_token"]').attr('content');
        Swal.fire({
            title: "Are you sure you want to delete this data?",
            text: "After you delete this data, there's no way to get it back",
            icon: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Yes"
        }).then((event) => {
            if (event.isConfirmed) {
                Swal.fire({
                    title : "",
                    text : "Harap Tunggu",
                    icon : "info",
                    showCancelButton: false,
                    showConfirmButton : false,
                    allowEscapeKey:false,
                    allowOutsideClick: false
                });

                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        "_token": token,
                        "_method": "DELETE"
                    }
                }).done((result) => {
                    if (result.status == 'success') {
                        Swal.fire({
                            title: "Data has been successfully deleted!",
                            text: "This page will be redirected automatically, please wait ...",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1000
                        }).then(() => {
                            location.reload();
                        })
                    } else {
                        Swal.fire({
                            title: "Failed!",
                            text: result.message,
                            icon: "warning",
                            showConfirmButton: false,
                            timer: 1000
                        }).then(() => {
                            location.reload();
                        })
                    }

                }).fail((error) => {
                    Swal.fire({
                        title: "Data Gagal Dihapus",
                        text: "Data Memiliki Relasi",
                        icon: "error",
                        showConfirmButton: false,
                        timer: 2000
                    });
                });
            } else if (event.dismiss === Swal.DismissReason.cancel) {
                Swal.fire('Cancelled', 'Delete data cancelled!', 'warning');
            }
        });
    });

    // Reset password
    $(".swal-reset").click(function () {
        url = $(this).data("url");
        Swal.fire({
            title: "Proceed to reset password?",
            text: "After you reset the password, the password will change to default",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Yes"
        }, function () {
            $.ajax({
                url: url,
                type: "GET",
                success: function() {
                    Swal.fire({
                        title: "The password has been reset successfully!",
                        text: "This page will be redirected automatically, please wait ...",
                        type: "success",
                        showConfirmButton: false,
                        timer: 1000
                    }, function () {
                        location.reload();
                    });
                },
                error: function(error){
                    Swal.fire({
                        title: "Sorry, something went wrong!",
                        text: error,
                        type: "error",
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });
        });
    });

    // Logout
    $(".swal-logout").click(function () {
        Swal.fire({
            title: "Logout User",
            text: "Proceed to leave this site?",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No"
        }, function () {
            window.ElenaCognito.logout();
        });
    });
});
