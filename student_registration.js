jQuery(function($) {
	jQuery("#file_select").click(function() {
		var test = document.getElementById("file_input");
		test.click();
	});
});
function print_filename() {
	// ファイル名のみ取得して表示します
	var filename = document.getElementById("file_input").value;
	var regex = /\\|\\/;
	var array = filename.split(regex);
	document.getElementById("text").value = array[array.length - 1];
}
