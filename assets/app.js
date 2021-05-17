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

import 'bootstrap/dist/js/bootstrap.bundle';

require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

//import "~bootstrap/scss/bootstrap";

import Chart from 'chart.js';

const $ = require('jquery');
//import $ from "jquery";
global.$ = global.jQuery = $;

// Add active state to sidbar nav links
var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
$("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function() {
    if (this.href === path) {
        $(this).addClass("active");
    }
});

// Toggle the side navigation
$("#sidebarToggle").on("click", function(e) {
    e.preventDefault();
    $("body").toggleClass("sb-sidenav-toggled");
});


$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

$(document).ready(function () {

    $('#deleteBtn').on('click', function () {
        var removeUrl = $(this).attr('data-remove-url');
        $('a.remove_item').attr('href', removeUrl);
    });

    $(".remove_item").on('click', function () {
        var removeUrl = $(this).attr('data-remove-url');
        $.ajax({
            url: removeUrl,
            type: 'POST',
        });
    });
});

$(".fa-chevron-circle-down").each(function() {
    var id = $(this).attr('id');
    document.getElementById(id).style.display="none";
});

$(".bets").each(function() {
    var id = $(this).attr('id');
    document.getElementById(id).style.display="none";
});

$(document).on('click', '.hideSpan', function()
{
    var id = $(this).attr('id');
    var lastIndex = id.lastIndexOf("_");
    var str = id.substring(0, lastIndex);

    if(document.getElementById('list_'+str).style.display=="none")
    {
        document.getElementById('list_'+str).style.display="block";
        document.getElementById(str+'_down').style.display="";
        document.getElementById(str+'_right').style.display="none";

        $(this).parent().removeClass("text-gray-500 border-transparent");
        $(this).parent().addClass("text-indigo-700 border-indigo-500");
    }
    else
    {
        document.getElementById('list_'+str).style.display="none";
        document.getElementById(str+'_down').style.display="none";
        document.getElementById(str+'_right').style.display="";

        $(this).parent().addClass("text-gray-500 border-transparent");
        $(this).parent().removeClass("text-indigo-700 border-indigo-500");
    }
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
            backgroundColor: ['rgba(42, 175, 40, 0.5)', "rgba(255,101,80, 0.5)"]
        }]
    },
    options: {
        responsive : true,
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
                backgroundColor: "rgba(42, 175, 40, 0.5)"
            }, {
                label: "Paris perdus",
                data: dataCountLoose,
                backgroundColor: "rgba(255,101,80, 0.5)"
            }
        ]
    },
    options: {
        responsive : true,
        legend: { display: false },
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
  	myColors[index]='rgba(255,101,80, 0.5)';
    labels[index]='Pertes'
  }else{
  	myColors[index]='rgba(42, 175, 40, 0.5)';
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
                backgroundColor: myColors,
                data: databenefPerte
            }
        ]
    },
    options: {
        responsive : true,
        legend: { display: false },
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
                backgroundColor: 'rgba(0,0,216,0.19)',
                fill: true,
                data: dataBankrollByDate
            }
        ]
    },
    options: {
        responsive : true,
        legend: { display: false },
    }
}); 