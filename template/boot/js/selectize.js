$(document).ready(function() {
//selectize
var xhr;
var select_hc, $select_hc;
var select_shc, $select_shc;
$select_hc = $('#hc').selectize({
	valueField: 'id',
    labelField: 'name',
    searchField: 'name',
    plugins: ['restore_on_backspace'],
    create: true,
	createOnBlur: true,
	openOnFocus: true,
	preload: true,
    load: function(query, callback) {
    this.settings.load = null;
        $.ajax({
            url: '../ajax/cat.php',
            type: 'POST',
		   dataType: 'json',
            data: {
                name: "load",
				hc: "1",
            },
            error: function() {
                callback();
            },
            success: function(res) {
                callback(res);
            }
        });
		(function(response){
            callback(response);
        },
		function(){
         callback();
        });
    },	
    onChange: function(value) {
        if (!value.length) return;
        select_shc.disable();
        select_shc.clearOptions();
        select_shc.load(function(callback) {
            xhr && xhr.abort();
            xhr = $.ajax({
             url: '../ajax/cat.php',
            type: 'POST',
		   dataType: 'json',
            data: {
				id: value,
                name: $("#hc option:selected").text(),
				shc: '1',
            },
                success: function(results) {
                    select_shc.enable();
                    callback(results);
                },
                error: function() {
					select_shc.disable();
                    callback();
                }
            })
        });
    }
});
$select_shc = $('#shc').selectize({
    valueField: 'id',
    labelField: 'name',
    searchField: 'name',
	plugins: ['restore_on_backspace'],
    create: true,
	createOnBlur: true,
	openOnFocus: true,
});
select_shc  = $select_shc[0].selectize;
select_hc = $select_hc[0].selectize;
select_shc.disable();
//disable Submit Button
$("#submit").attr('disabled', 'disabled');
$("#submit").attr('class', 'btn btn-danger btn-block');
$("form").keyup(function() {
// To Disable Submit Button
$("#submit").attr('disabled', 'disabled');
$("#submit").attr('class', 'btn btn-danger btn-block');
// Validating Fields
var name = $("#naam").val();
var hc = $("#hc option:selected").text();
var shc = $("#shc option:selected").text();
var info = $("#summernote").val();
if (!(name == "" || hc == "" || shc == "" || info == "" || hc.match(/^\d+$/) || shc.match(/^\d+$/) )){
	
// To Enable Submit Button
$("#submit").removeAttr('disabled');
$("#submit").removeAttr('class');
$("#submit").attr('class', 'btn btn-success btn-block');
}
});
});