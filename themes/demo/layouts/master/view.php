<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no maximum-scale=1, minimum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/landingpage/css/landingpage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
        <div>
            <?= $body ?>
        </div>





    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
       $(document).ready(function() {
            // Listen for click event on elements with data-bs-toggle="collapse"
            $('[data-bs-toggle="collapse"]').on('click', function () {
                // Find the plus and minus icons within the clicked element
                var $iconPlus = $(this).find('.fa-plus');
                var $iconMinus = $(this).find('.fa-minus');

                // Toggle the visibility of plus and minus icons
                $iconPlus.toggleClass('d-none');
                $iconMinus.toggleClass('d-none');
            });

            $('#email-form').on('submit', function(){
                event.preventDefault();

                var formData = $(this).serialize();

                // Make an AJAX request
                $.ajax({
                    type: 'POST', // or 'GET'
                    url: '/bc/sendemail-contact',
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Email Sent Successfully',
                            icon: 'success',
                            confirmButtonText: 'Okay'
                        })
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            })
        });
    </script>
</body>

</html>
