<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="Edutech Management">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('alsavedutech/images/bg-1.png') }}" />
    <title>@yield('title')</title>
    @stack('css')
</head>

<body>

    <body class="bg-light">
        @yield('content')
    </body>
</body>

@stack('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    var flashData, typeflash, icons, message, form

    flashData = $('.flash-data').data('flashdata')
    typeflash = $('.type-flash').data('typeflash')

    if (typeof(typeflash) != null && typeflash == 'error') {
        icons = 'error'
        message = 'Error Data'
    } else {
        icons = 'success'
        message = 'Successfully Data'
    }

    if (flashData) {
        Swal.fire({
            title: message,
            text: flashData,
            icon: icons,
        });
    }

    $('.show_confirm_delete').click(function(e) {
        form = $(this).closest("form")
        e.preventDefault();

        Swal.fire({
            title: "Apakah anda yakin ingin menghapus data?",
            text: "data yang terhapus tidak bisa di kembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit()
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Unsuccessfully Data",
                    text: "data tidak dihapus !",
                    // footer: '<a href="#">Why do I have this issue?</a>'
                });
            }
        });
    })
</script>

</html>
