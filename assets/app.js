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

import Chart from 'chart.js';

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

var ctx = document.querySelector('#statsWinLoose');
var resultCount = ctx.dataset.resultCount;
var data = JSON.parse(resultCount);
var myChart1 = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ["Gagnés", "Perdus"],
        datasets: [{
            label: "Gagné/Perdu",
            data: data,
            backgroundColor: ['rgba(42, 175, 40, 0.5)', "red"]
        }]
    },
    options: {
        responsive : true,
        title: {
            display: true,
            text: 'Répartition des paris gagnés et perdus'
          }
    }
}); 

var ctx = document.querySelector('#statsCountByDate');
var countWin = ctx.dataset.countWin;
var countLoose = ctx.dataset.countLoose;
var dates = ctx.dataset.dates;
var dataCountWin = JSON.parse(countWin);
var dataCountLoose = JSON.parse(countLoose);
var dataDates = JSON.parse(dates);
var myChart2 = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: dataDates,
        datasets: [
            {
                label: "Paris gagnants",
                data: dataCountWin,
                backgroundColor: "green"
            }, {
                label: "Paris perdus",
                data: dataCountLoose,
                backgroundColor: "red"
            }
        ]
    },
    options: {
        responsive : true,
        legend: { display: false },
        title: {
            display: true,
            text: 'Nombre de paris Gagné/Perdu par date'
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
}); 

var ctx = document.querySelector('#statsBenefPerteByDate');
var benefPerte = ctx.dataset.benefPerte;
var dates = ctx.dataset.dates;
var databenefPerte = JSON.parse(benefPerte);
var dataDates = JSON.parse(dates);
var myColors=[];
var labels=[];

$.each(databenefPerte, function( index,value ) {
  if(value<0){
  	myColors[index]='red';
    labels[index]='Pertes'
  }else{
  	myColors[index]='green';
    labels[index]='Bénéfices'
  }
});

var myChart3 = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: dataDates,
        datasets: [
            {
                label: labels,
                borderColor: myColors,
                borderWidth: 3,
                fill: false,
                data: databenefPerte
            }
        ]
    },
    options: {
        responsive : true,
        legend: { display: false },
        title: {
            display: true,
            text: 'Bénéfices/Pertes par date'
        }
    }
}); 

var ctx = document.querySelector('#statsBankrollByDate');
var bankrollByDate = ctx.dataset.bankrollDate;
var dates = ctx.dataset.dates;
var dataBankrollByDate = JSON.parse(bankrollByDate);
var dataDates = JSON.parse(dates);
var myChart4 = new Chart(ctx, {
    type: 'line',
    data: {
        labels: dataDates,
        datasets: [
            {
                label: 'Bankroll',
                borderColor: 'red',
                fill: false,
                data: dataBankrollByDate
            }
        ]
    },
    options: {
        responsive : true,
        legend: { display: false },
        title: {
            display: true,
            text: 'Evolution de la bankroll'
        }
    }
}); 