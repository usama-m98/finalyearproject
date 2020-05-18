"use-strict";


// functions that applies the slideshow of project images

//constants
let slideIndex = 1
showSlides('#slides1 .mySlides');
const prevSlide = document.getElementById("prev-slide");
const nextSlide = document.getElementById("next-slide");

prevSlide.addEventListener("click", ev => previousSlide('#slides1 .mySlides'));
nextSlide.addEventListener("click", ev => plusSlide('#slides1 .mySlides'));

function previousSlide(query) {
    slideIndex -= 1;
    showSlides(query);
}

function plusSlide(query) {
    slideIndex += 1;
    showSlides(query);
}


function showSlides(query) {
    let n = slideIndex;
    const slides = document.querySelectorAll(query);
    if (n > slides.length) {
        slideIndex = 1
    };
    if (n < 1) {
        slideIndex = slides.length
    };
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[slideIndex - 1].style.display = "block";
}