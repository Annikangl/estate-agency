require('./bootstrap');

// core version + navigation, pagination modules:
import Swiper, {Navigation, Pagination} from 'swiper';
// import Swiper and modules styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

$(document).ready(function () {

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


