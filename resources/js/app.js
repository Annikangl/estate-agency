require('./bootstrap');


// core version + navigation, pagination modules:
import Swiper, {Navigation, Pagination} from 'swiper';
// import Swiper and modules styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';


$(document).ready(function () {
    console.log($('.summernote'))
});

$(document).on('click', '.phone-button', function () {
    let btn = $(this);

    axios.post(btn.data('source')).then(function (response) {
        btn.find('.number').html(response.data);
    }).catch(function (reason) {
        console.log(reason);
    });
});


const swiper = new Swiper('.swiper', {
    loop: true,
    slidesPerView: 1,
    spaceBetween: 30,
    centeredSlides: true,
    breakpoints: {
        640: {
            slidesPerView: 1,
            spaceBetween: 10,
        },
        768: {
            slidesPerView: 2,
            spaceBetween: 20,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 30
        }
    }

});

$('.banner').each(function () {
    let block = $(this);

    let url = block.data('url');
    let format = block.data('format');
    let category = block.data('category');
    let region = block.data('region');

    axios.get(url, {
        params: {
            format: format,
            category: category,
            region: region
        }
    }).then(function (response) {
        console.log(response);
        block.html(response.data);
    })
        .catch(function (error) {
            console.error(error);
        })
})

$(document).on('click', '.location-btn', function () {
    let button = $(this);
    let target = $(button.data('target'));

    window.geocode_callback = function (response) {
        if (response.response.GeoObjectCollection.metaDataProperty.GeocoderResponseMetaData.found > 0) {
            target.val(response.response.GeoObjectCollection.featureMember['0'].GeoObject.metaDataProperty.GeocoderMetaData.Address.formatted);
        } else {
            alert('Unable to detect your address.');
        }
    };

    if (navigator.geolocation) {
        console.log(navigator.geolocation);

        navigator.geolocation.getCurrentPosition(function (position) {
            let location = position.coords.longitude + ',' + position.coords.latitude;
            let url = 'https://geocode-maps.yandex.ru/1.x/?format=json&callback=geocode_callback&apikey=74b6c04b-1a25-40a6-b89d-abb57317616a&geocode=' + location;
            let script = $('<script>').appendTo($('body'));
            script.attr('src', url);

            console.log(location, url, script);
        }, function (error) {
            console.warn(error.message);
        });
    } else {
        alert('Unable to detect your location.');
    }
});



