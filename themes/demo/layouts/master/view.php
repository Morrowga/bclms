<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no maximum-scale=1, minimum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/css/splide.min.css">

    <title><?= $page->get('title') ?></title>
    <link rel="stylesheet" href="<?= phpb_theme_asset('materialui/assets/vendor/fonts/fontawesome.css')?>" />
    <link rel="stylesheet" href="/landingpage/css/landingpage.css">
</head>

<body>
        <div class="container">
            <?= $body ?>
        </div>





    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/js/splide.min.js"></script>
    <script>
        var splide = new Splide('.splide', {
            type: 'loop',
            perPage: 4,
            rewind: true,
            breakpoints: {
                640: {
                    perPage: 2,
                    gap: '.7rem',
                    height: '12rem',
                },
                480: {
                    perPage: 1,
                    gap: '.7rem',
                    height: '12rem',
                },
            },
        });
        splide.mount();

        var splide_game = new Splide('.splide-game', {
            type: 'loop',
            perPage: 4,
            rewind: true,
            breakpoints: {
                640: {
                    perPage: 2,
                    gap: '.7rem',
                    height: '12rem',
                },
                480: {
                    perPage: 1,
                    gap: '.7rem',
                    height: '12rem',
                },
            },
        });
        splide_game.mount();
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>
