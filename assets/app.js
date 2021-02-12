/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

//import "~bootstrap/scss/bootstrap";

const $ = require('jquery');

$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

$(document).ready(function() {
    // On récupère la balise <div> en question qui contient l'attribut <<data-prototype>> qui nous intéresse
    var $container = $('div#bet_test_gamestest');

    // On ajoute un lien pour ajouter un nouveau paris
    var $addLink = $('<a href="#" id="add_game" class="btn btn-success">Ajouter un paris</a>');

    $container.append($addLink);

    // On ajoute un nouveau champ à chque clic sur le lien d'ajout
    $addLink.click(function(e) {
        addGameTest($container);
        e.preventDefault(); // Evite qu'un # apparaisse dans l'URL

        return false;
    });

    // On définit un index unique pour nommer les champs qu'on va ajouter dynamiquement
    var index = $container.find(':input').length;

    if(index != 0) {
        // Pour chaque GameTestType déjà existant on ajoute un lien de suppression
        $container.children('div').each(function() {
            addDeleteLink($(this));
        })
    }

    // La fonction qui ajoute un formulaire GameTestType
    function addGameTest($container) {
        // Dans le contenu de l'attribut <<data-prototype>>, on remplace :
        // Le texte "__name__label__" qu'il contient par le label du champ
        // Le texte "__name__" qu'il contient par le numéro du champ
        var $prototype = $($container.attr('data-prototype').replace(/__name__label__/g, 'GameTest n°' + (index+1)).replace(/__name__/g, index));

        // On ajoute au prototype un lien pour pouvoir supprimer le GameTestType
        addDeleteLink($prototype);

        // On ajoute le prototype modifié à la fin de la balise <div>
        $container.append($prototype);

        // Enfin, on incrémente le compter pour que le prochain ajout se fasse avec un autre numéro
        index++;

        // La fonction qui ajoute un lien de suppression d'un distributeur
        function addDeleteLink($prototype) {
            // Création du lien
            var $deleteLink = $('<a href="#" class="btn btn-danger">Supprimer</a>');

            // Ajout du lien
            $prototype.append($deleteLink);
            
            // Ajout du listener sur le click du lien
            $deleteLink.click(function(e) {
                $prototype.remove();
                e.preventDefault(); // Evite qu'un # apparaisse dans l'URL

                return false;
            });
        }
    }
})

