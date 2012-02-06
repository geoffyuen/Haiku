$.fn.clearForm = function() {
  $( this ).
    find( ':text, :password, textarea' ).
      attr( 'value', '' ).end().
    find( ':checkbox, :radio' ).
      attr( 'checked', false ).end().
    find( 'select' ).
      attr( 'selectedIndex', -1 );
}


$(document).ready(function () {

/* 	$('textarea').tabby(); */
	
	$('#announcement').click(function(){
		$(this).hide();
	});
	
	$('#editbtn').click(function(){
		$('#feditor').show();
		$('#content').hide();
	});
	
	$('#newbtn').click(function(){
		$('#feditor').show();
		$('#content').hide();
		$('#feditor').clearForm();
		$.ajax({
			url : "documents/Template.txt",
			success : function (data) {
			$("#fnotes").val(data);
			}
		});
	});
	
	$('#frevert').click(function(){
		$( "#feditor" )[ 0 ].reset();
	});
			
	$('#fcancel').click(function(){
		$( "#feditor" )[ 0 ].reset();
		$('#feditor').hide();
		$('#content').show();
	});

	$('#fclear').click(function(){
		$("#feditor").clearForm();
	});

/* 	filter strings as you type in the search input */
	$("#search").keyup(function () {
		var filter = $(this).val();
		$("#documents:first li").each(function () {
			if ($(this).text().search(new RegExp(filter, "i")) < 0) {
				$(this).css({'display' : 'none'});
            } else {
                $(this).css({'display' : 'block'});
            }
		});
	});
	
/* 	select all text in input on click */
	$('#username, #password, #search').click(function(){
		$(this).select();
	});
	
	
/* 	keyboard shortcuts */
jwerty.key('cmd+option+e', function() {
	$('#feditor').toggle();
	$('#content').toggle();
});

jwerty.key('cmd+option+s', function() {
	if ($("#feditor").css("display") != "none") {
		$('#fsave').trigger('click');	
	}
});

jwerty.key('esc',function() {
	$('#fcancel').trigger('click');
  	$('#announcement').hide();
});


setTimeout( function() {
		$('#announcement').fadeOut();
}, 10000 );



});
