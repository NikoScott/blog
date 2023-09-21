/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');
require('bootstrap')

// start the Stimulus application
import './bootstrap';


// loads the jquery package from node_modules
import $ from 'jquery';



//////
// faire disparaitre les messages flash au bout de 5 secondes
////////
setTimeout(function() {
    var confirmationMessage = document.getElementById('confirmation-message');
    if (confirmationMessage) {
        confirmationMessage.style.display = 'none';
    }
}, 5000); // 5000 millisecondes = 5 secondes


////
// ajouter une catégorie san passer par le back office
$("#newCategory").click(function(e) {
    e.preventDefault();
    $('.show_category').toggleClass('d-none');
});


/// barre de recherche
////////////
$("#search-content").on('keydown', function(e) {

    if(e.key === "Enter" || e.keyCode === 13) {

        e.preventDefault();// j'empêche le formulaire de se soumettre

        $.ajax({
            url:'/search',
            data: {
                "search": $("#search-content").val()
            },
            dataType: 'json',
            success: function (data) // obj json => un array d'objet
            {
                let contentHtml = "";

                contentHtml += "<h2 class='text-primary-emphasis mb-5'> Nos articles liés à la recherche : " + $("#search-content").val() + "  </h2>";

                for(let i = 0; i < data.length; i++) {
                    contentHtml += "<div class='articleMain d-flex my-3'>"+
                                        "<a class='d-flex text-decoration-none text-reset' href='/article/" + data[i].id + "'>"+
                                            "<img id='imgArticle' class='custom-shadow' src='/images/articles/" + data[i].picture + "'>"+
                                            "<div class='d-flex flex-column text-body-secondary mb-1 ps-2'>"+
                                                "<h2 class='h3 fst-normal text-primary-emphasis ms-3'>" + data[i].title + " </h2>"+
                                                "<a class='h3 fst-italic text-primary-emphasis ms-3' style='font-size:12px'>" + data[i].date + " </a>"+
                                                "<p id='catchPhrase' class='mb-2 fst-normal text-body-secondary ms-3' style='font-size:16px'>" + data[i].catchPhrase  + " </p>"+
                                            "</div>"+
                                        "</a>"+
                                    "</div>";
                }
                // dans la classe main-content
                // met le contenu
                $(".main-content").html(contentHtml);
            }
        });
    }
});


$("#btn-search").on('click', function(e) {

        e.preventDefault();// j'empêche le formulaire de se soumettre

        $.ajax({
            url:'/search',
            data: {
                "search": $("#search-content").val()
            },
            dataType: 'json',
            success: function (data) // obj json => un array d'objet
            {
                let contentHtml = "";

                contentHtml += "<h2 class='text-primary-emphasis mb-5'> Nos articles liés à la recherche : " + $("#search-content").val() + "  </h2>";

                for(let i = 0; i < data.length; i++) {
                    contentHtml += "<div class='articleMain d-flex my-3'>"+
                                        "<a class='d-flex text-decoration-none text-reset' href='/article/" + data[i].id + "'>"+
                                            "<img id='imgArticle' class='custom-shadow' src='/images/articles/" + data[i].picture + "'>"+
                                            "<div class='d-flex flex-column text-body-secondary mb-1 ps-2'>"+
                                                "<h2 class='h3 fst-normal text-primary-emphasis ms-3'>" + data[i].title + " </h2>"+
                                                "<a class='h3 fst-italic text-primary-emphasis ms-3' style='font-size:12px'>" + data[i].date + " </a>"+
                                                "<p id='catchPhrase' class='mb-2 fst-normal text-body-secondary ms-3' style='font-size:16px'>" + data[i].catchPhrase  + " </p>"+
                                            "</div>"+
                                        "</a>"+
                                    "</div>"+
				                    "<div class='separator mt-5 mb-5' style='height:2px;background:rgba(255,255,255, 0.05);'></div>";

                }
                // dans la classe main-content
                // met le contenu
                $(".main-content").html(contentHtml);
            }
        });
    }
);
