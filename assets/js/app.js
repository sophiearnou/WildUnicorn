import('./common');
import $ from 'jquery';
console.log($)


/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import "../scss/app.scss";

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';
import('./home');





// Search
/*const search = document.querySelector('.search > input[type="text"]');
const result = document.querySelector('.search > .search-result');

search.addEventListener('focus', (event) => {
    event.currentTarget.addEventListener('keyup', (event) => {
        const q = event.currentTarget.value;
        if(q.length >= 2) {

            $.ajax({
                type: "POST",
                url: "/fr/event/search",
                data: {q: q},
                success: function(data) {
                    result.innerHTML = null;
                    data.forEach(event => {
                        let a = document.createElement('a');
                        a.setAttribute('href', event.url);
                        a.innerHTML = event.title + ' <span style="font-weight: bold">'+ event.category +'</span>';
                        a.style.color = 'white';
                        a.style.backgroundColor = 'red';
                        a.style.textAlign = 'left';
                        a.style.display = 'block';
                        a.style.padding = '10px 20px';
                        a.style.width = '100%';
                        result.appendChild(a);
                    });
                },
                dataType: "json"
            });
        } else {
            result.innerHTML = null;
        }
    });
});*/
$(document).ready(function () {
    // je mets un écouteur sur le focus
    $('.search > input[type="text"]').on('focus', function (e) {
        e.preventDefault();
        // tu me déclenche sur l'evenemùent
        $(this).on('keyup', function (e) {
            e.preventDefault();
            // pour chaquer frappe au clavier tu récupère la valeur
            let q = $(this).val();

            if (q.length >= 2) {
                $.ajax({
                    //J'interroge le server sur l'url "/fr/event/search" via ajax avec la méthode post
                    type: "POST",
                    url: "/fr/event/search",
                    //paramètres qu'on passe à la requète si je suis en get data transmet dans dans l'url et si je suis en post data transmet dans le corp de la requête
                    data: { q: q },//on transmets l'objet q dans la requète clé et valeur
                    success: function (data) {//méthode de réponse la clé est success contient une fonction annonyme data qui est la réponse qu'on attend du server
                        $('.search-result').html(null);//je réinitialise à 0 le contenu
                        if (data.length > 0) {
                            $.each(data, function (i, event) {
                                console.log(event);
                                //à chaque itération j'ajoute le contenu du lien
                                //console.log(data);
                                // pour chaque element dans le tableau tu récupère un tableau évenement
                                $('.search-result')
                                    .append('<a href="'
                                        + event.url
                                        + '" style="color:white;background-color:rgba(209,0,198,1);display:block;padding:10px 20px;width: 100%;">'
                                        + event.title
                                        + ' <span>'
                                        + event.category
                                        + '</span></a>');
                            })

                        } else {
                            $('.search-result').html(null)
                                .append('<p " style="color: rgba(209, 0, 198, 1); display: block; padding: 10px 20px; width: 100 %; ">'
                                    + 'Il n\' a pas d\'événement'
                                    + '<p/>');
                        }
                    },
                    // j'attends du json
                    dataType: "json"
                });
            } else {
                $('.search-result').html(null);
            }
        });
    });
});



