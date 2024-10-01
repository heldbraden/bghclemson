var pageCount = 0;

function searchMusic() {
    var searchTerm = document.getElementById('input_search');
    console.log(searchTerm);
    let request = new XMLHttpRequest();
    request.open("GET", `https://itunes.apple.com/search?term=${searchTerm}`);
    request.send();
    request.onload = () => {
        console.log(request);
        if (request.status == 200) {
            console.log(JSON.parse(request.response));

            var container = document.getElementById("album_list_container");
            var template = "";

            for (var i = 0; i < request.results.length; i++) {
                if (pageCount < 10) {
                    template += '<div class="cardObject">';
                    template += '<div class="itemPic" style="background:url(' + request.results[i].artworkUrl100 + ')"></div>';
                    template += '<div class="itemTitle">' + request.results[i].artistName + '</div>';
                    template += '<div class="itemPrice"><span>Price: </span>' + request.results[i].collectionPrice + 'USD </div>';
                    template += '</div>';
                    pageCount++;
                }
            }

            var more = '<div><button onclick="addMore">More</Button></div>';

            container.innerHTML = '';
            container.insertAdjacentHTML('afterbegin', template);
            container.insertAdjacentHTML('afterbegin', more);

        } else {
            console.log("error");
        }
    }
}

function getStats() {
    let request = new XMLHttpRequest();
    request.open("GET", `https://itunes.apple.com/search?term=${stats}`);
    request.send();
    request.onload = () => {
        console.log(request);
        if (request.status == 200) {
            console.log(JSON.parse(request.response));
            var movie = document.getElementById('movieStats');
            var pod = document.getElementById('podStats');
            var music = document.getElementById('musicStats');
            var aBook = document.getElementById('aBookStats');
            var tv = document.getElementById('tvStats');
            var eBook = document.getElementById('eBookStats');

        } else {
            console.log("error");
        }
    }
}

function addMore() {
    pageCount += 10;
    searchMusic();
}
