//
$(function(){
	//項目区分切替時処理.
	$('#employeetype').on('change', function(){
		var id = $(this).val();
		$('[data-tableid=1]').css( "display", "none" );
		$('[data-tableid=2]').css( "display", "none" );
		$('[data-tableid=3]').css( "display", "none" );
		$('[data-tableid=4]').css( "display", "none" );
		$('[data-tableid=9]').css( "display", "none" );
				
		$('[data-tableid='+id+']').css( "display", "block" );
	});
});
