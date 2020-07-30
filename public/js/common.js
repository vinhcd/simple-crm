function IsNumeric(input){
	var RE = /^-{0,1}\d*\.{0,1}\d+$/;
	return (RE.test(input));
}


function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function autocomma(input)
{
	var nStr = input.value + '';
	nStr = nStr.replace( /\,/g, "");
	var x = nStr.split( '.' );
	var x1 = x[0];
	var x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while ( rgx.test(x1) ) {
		x1 = x1.replace( rgx, '$1' + ',' + '$2' );
	}
	input.value = x1 + x2;
}

function formatMoney(val){
	while (/(\d+)(\d{3})/.test(val.toString())){
	  val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
	}
	return val;
}

function lamtron(val){
	var temmonery=val.toString();
	if (temmonery.indexOf(".")>0){
		return temmonery.substring(temmonery.indexOf("."),0);
	}else{
		return temmonery;
	}
}  