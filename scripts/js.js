/** Date Picker **/
$('.input-group.date').datepicker({
    format: "dd/mm/yyyy",
    clearBtn: true,
    language: "fr",
    autoclose: true,
    daysOfWeekDisabled: "0",
    todayHighlight: true,
    forceParse: false
});

//Info Text
$(".alert-message").delay(2000).fadeOut("slow");


// Objectifs
flagObj = 'operateur';

$('.champs').addClass('btn-success');
$('.operateur').addClass('btn-danger');

function addObjOperateur(operateur) {
    if(flagObj != 'operateur'){
        $('#calculObj').val($('#calculObj').val() + operateur);
        flagObj = 'operateur';


        $('.operateur').removeClass('btn-success');
        $('.operateur').addClass('btn-danger');

        $('.champs').removeClass('btn-danger');
        $('.champs').addClass('btn-success');
    }
}

function addObjChamps(champs){
    if(flagObj != 'champs'){
        $('#calculObj').val($('#calculObj').val() + champs);
        flagObj = 'champs';

        $('.champs').removeClass('btn-success');
        $('.champs').addClass('btn-danger');

        $('.operateur').removeClass('btn-danger');
        $('.operateur').addClass('btn-success');
    }
}

function resetObj(){
    $('#calculObj').val('');
    flagObj = 'operateur';

    $('.champs').removeClass('bnt-success');
    $('.champs').addClass('bnt-danger');

    $('.operateur').removeClass('bnt-danger');
    $('.operateur').addClass('bnt-success');
}

function addAtelier(){
    $number = $("#endOfAtelier").val();
    $("#endOfAtelier").before("<div class='list-group'><div class='list-group-item has-feedback'><label class='control-label' for='idWarning'>Nom</label><input type='text' name='atelierName" + $number  + "' id='atelierName" + $number  + "' class='form-control'></div></div>");
    $number = parseInt($number) + 1 ;
    $('#endOfAtelier').val($number);
}

function addChamps(){
    $number = $("#endOfChamps").val();

    $("#endOfChamps").before("<div class='list-group-item has-feedback col-xs-12'><label class='control-label' for='idWarning'>Nom</label><input type='text' name='chpLibel" + $number  + "' id='chpLibel" + $number  + "' class='form-control'></div>");

    $number = parseInt($number) + 1 ;
    $('#endOfChamps').val($number);
}