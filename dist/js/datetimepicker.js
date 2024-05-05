$(document).ready(function () {
    $('.datetimepicker').datetimepicker({
        format: 'Y-m-d H:i',  // Format de date et d'heure souhaité
        step: 15  // Intervalle entre les minutes
    });
});