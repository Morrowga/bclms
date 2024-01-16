<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no maximum-scale=1, minimum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/css/splide.min.css">

    <title><?= $page->get('title') ?></title>
    <link rel="stylesheet" href="<?= phpb_theme_asset('materialui/assets/vendor/fonts/fontawesome.css')?>" />
    <link rel="stylesheet" href="/landingpage/css/landingpage.css">
</head>

<body>
        <div>
            <?= $body ?>
        </div>





    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/js/splide.min.js"></script>
    <script>
        var baseUrl = window.location.origin;
        var story_card = document.getElementById('story_card');
        var game_card = document.getElementById('game_card');
        var no_data_text = document.getElementById('no_data_text');
        var no_data_text_toy = document.getElementById('no_data_text_toy');
        var noDataToy = document.getElementById('no_data_toy');
        var noDataGame = document.getElementById('no_data_game');

        fetch(baseUrl +"/api/landingpage")
            .then((response) => response.json())
            .then((json) => {
                console.log(json);
                addCardToHTML(json.data.books, story_card, 'toy', noDataToy, no_data_text_toy);
                addCardToHTML(json.data.games, game_card, 'game', noDataGame, no_data_text);

                splideCard('splide');
                splideCard('splide-game');
            });

        function splideCard(className)
        {
            var splide = new Splide('.'+ className, {
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
            })
            splide.mount();
        }

        function addCardToHTML(data, cardName, card, noData, noDataText)
        {
            if(data.length == 0)
            {
                noDataText.style.display = 'none';
                noData.innerHTML += '<h4 class="text-center muted mt-3">No Data</h4>';
            }else{
                data.forEach(d => {
                    var thumbnail = card == 'game' ? d.thumbnail : d.thumbnail_img;
                    var thumbnail_img = thumbnail == '' ? '/images/image1.png' : thumbnail;
                    var content = `<div class="col-sm-4 splide__slide m-2">
                                        <div class="card-wrapper d-flex justify-content-around">
                                            <div class="card p-3" style="width: 300px !important">
                                                <img src="${thumbnail_img}" height="135" class="card-img-top" alt="...">
                                                <div class="card-body p-0 mt-2">
                                                    <h5 class="card-title mb-0 text-center theme-bold-font">${d.name}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                    cardName.innerHTML += content;
                });
            }
        }

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>
