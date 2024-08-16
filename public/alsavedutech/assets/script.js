new DataTable("#example");
new DataTable("#pengajuan-sallary");
new DataTable("#list-after-pengajuan");

new DataTable("#trashDataTable");

$(document).ready(function () {
    $("#jam_mulai_jadwal_kelas").mask("00:00");
});

$(document).ready(function () {
    $("#jam_mulai_jadwal_kelas_edit").mask("00:00");
});

$(document).ready(function () {
    $("#jam_akhir_jadwal_kelas").mask("00:00");
});

$(document).ready(function () {
    $("#jam_akhir_jadwal_kelas_edit").mask("00:00");
});

$(document).ready(function () {
    $(".select2").select2({
        closeOnSelect: false,
    });
});
