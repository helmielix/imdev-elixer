$('.btnDownload').click(function(e){
	e.preventDefault();  //stop the browser from following
	window.open('../img/Syarat pengajuan PSP dan Penawaran WPSPE.pdf', '_blank');
	$('.formContainer').show();
});
