var $j = jQuery.noConflict();
$j( document ).on( "keydown", function( event ) {
	var keyCode = event.keyCode;
	
	if(keyCode == 116) {
	//console.log("F5");
	return false;
	}
	
	//f1
	if(keyCode == 112) add(1);

	//f2
	if(keyCode == 113) add(2);

	//f3
	if(keyCode == 114) location.href="/sale/";

	
});



function add(opt){
	var $j = jQuery.noConflict();

	if (document.getElementById("customerid").value!="" && document.getElementById("customerid").value.length<10){
		alert("Mã khách hàng phải lớn hơn 9 số, vui lòng nhập số điện thoại.");
		$j( "#customerid" ).focus();
		return;		
	}

	if (document.getElementById("customerid").value!="" && document.getElementById("customer_name").value==""){
		alert("Chưa nhập tên khách hàng");
		$j( "#customer_name" ).focus();
		return;		
	}


	if (document.getElementById("nomoi").value!="" && document.getElementById("customerid").value==""){
		alert("Chưa nhập khách hàng");
		$j( "#customerid" ).focus();
		return;		
	}

	

	var ex="";
	$j.ajax({
		data: {
			'invoiceid': document.getElementById("invoiceid").value               
		},
		type: 'POST',
		url: "/sale/chkcart/",
		async: false,
		cache: false,
	success: function(response){
		ex=response;
	}
	});		
	
	
	if (ex=="empty"){
		alert("Chưa nhập sản phẩm nào");
		document.getElementById("productid").focus();
		return false;	
	}	
	
	
	var myRadio1 = $j('input[name=sex]');
	var sex = myRadio1.filter(':checked').val();
	if (sex == undefined) sex="";

	var myRadio2 = $j('input[name=pay_method]');
	var pay_method = myRadio2.filter(':checked').val();

	var myRadio3 = $j('input[name=giaodich]');
	var giaodich = myRadio3.filter(':checked').val();
	
	var off_type=0; //tien mat
	if(document.getElementById('chk_unit_ck2').checked)  off_type=1; //%
	
	var chkthanhtoan=1;
	if (document.getElementById("chkdebtpay").checked) chkthanhtoan=2;



	//save data
	$j.ajax({
		data: {
			'customerid': document.getElementById("customerid").value,
			'customer_name': document.getElementById("customer_name").value,
			'sex':sex,
			'phone': document.getElementById("phone").value,
			'birthday': document.getElementById("birthday").value,
			'mail': document.getElementById("mail").value,
			'address': document.getElementById("address").value,		
			'pay_method':pay_method,
			'ck2': document.getElementById("ck2").value,
			'off_type':off_type,
			'khachtra': document.getElementById("pay").value,
			'tralaikhach': document.getElementById("tralaikhach").innerHTML,
			'point_use': document.getElementById("diemsudung").innerHTML,
			'invoiceid': document.getElementById("invoiceid").value,
			'note': document.getElementById("note").value,
			'saledate': document.getElementById("invoice_date").value,
			'amount': document.getElementById("tongthanhtoan").innerHTML,
			'amount2': document.getElementById("amount2").value,
			'rebate': document.getElementById("ck2").innerHTML,
			'online':giaodich,
			'vat': document.getElementById("vat").value,			
			'vat_amount': document.getElementById("tienvat").innerHTML,
			'tongtienhang': document.getElementById("tongtien").innerHTML,
			'amount_novat': document.getElementById("tongchuavat").innerHTML,
			'point_money': document.getElementById("tiendiem").innerHTML,
			'diemtichluy': document.getElementById("diemtichluy").innerHTML,
			'thanhtoan': document.getElementById("thanhtoan").value,
			'nomoi': document.getElementById("nomoi").value,
			'chkthanhtoan': chkthanhtoan,			
			/*'diemdu': document.getElementById("diemdu").innerHTML,
			'sudungdiem': sudungdiem,			
			'tonggiagoc': document.getElementById("tonggiagoc").innerHTML,
			'sauck1': document.getElementById("sauck1").innerHTML,
			
			'sauck2': document.getElementById("sauck2").innerHTML,
			
			
			'
			'tongcovat': document.getElementById("tongcovat").innerHTML,
			'tongthanhtoan': document.getElementById("tongthanhtoan").innerHTML,

			
						
			
			'tongck1': document.getElementById("tongck1").innerHTML,
			'ck2_amount': document.getElementById("ck2_amount").innerHTML			
			*/
		},
		type: 'POST',
		url: "/sale/saveinvoice/",
		async: false,
		cache: false,
		success: function(response){
		//alert(response);
		
			if (response=="ok"){
				if (opt==1){
					//alert("Lưu thành công");
					window.location = "/sale/";
				}else{//print invoice
	
					if (document.getElementById("pay").value!=""){
						document.getElementById("khachdua2").innerHTML=document.getElementById("pay").value;
						document.getElementById("tralaikhach2").innerHTML=document.getElementById("tralaikhach_v").innerHTML;
					}else{
						document.getElementById("khachdua2").innerHTML="0";
						document.getElementById("tralaikhach2").innerHTML="0";
					}	
	
					if (document.getElementById("vat").value!=""){
						document.getElementById("vat2").innerHTML=document.getElementById("vat").value;					
					}else{
						document.getElementById("vat2").innerHTML="0";
					}
	
	
					if (document.getElementById("tienvat").innerHTML!=""){
						document.getElementById("vat_amount2").innerHTML=document.getElementById("tienvat").innerHTML;
					}else{
						document.getElementById("vat_amount2").innerHTML="0";
					}	
	
					if (document.getElementById("ck2").value!="")
						document.getElementById("chietkhau2").innerHTML=document.getElementById("ck2").value;
					else
						document.getElementById("chietkhau2").innerHTML=0;
					
					document.getElementById("tiendiem2").innerHTML=document.getElementById("tiendiem").innerHTML;
					
					if (document.getElementById("thanhtoan").value!="")
						document.getElementById("thanhtoan2").innerHTML=document.getElementById("thanhtoan").value;
					else
						document.getElementById("thanhtoan2").innerHTML="0";
	
					if (document.getElementById("nomoi").value!="")
						document.getElementById("nomoi2").innerHTML=document.getElementById("nomoi").value;
					else
						document.getElementById("nomoi2").innerHTML="0";

					if (document.getElementById("tongthanhtoan").value!="")
						document.getElementById("tongthanhtoan2").innerHTML=document.getElementById("tongthanhtoan").innerHTML;
					else
						document.getElementById("tongthanhtoan2").innerHTML="0";
					
					
					if ($j('input[name=pttt]:checked').val()==1)
						document.getElementById("pp_thanhtoan").innerHTML="Tiền mặt";
					else
						document.getElementById("pp_thanhtoan").innerHTML="Thẻ";			
						
					if ($j('input[name=giaodich]:checked').val()==1)
						document.getElementById("dd_giaodich").innerHTML="Tại cửa hàng";
					else
						document.getElementById("dd_giaodich").innerHTML="Online";			
	
					
					
					
					printDiv('printdiv');
	
				}
			}else{
				alert("Xẩy ra lỗi, thử lại sau ít phút.");
			}
		}
	});	
	
	
	/*if (document.getElementById("branchid").value==""){
		alert("Chưa nhập [Chi nhánh]");
		document.getElementById("branchid").focus();
		return false;
	}

	if (document.getElementById("request_date").value==""){
		alert("Chưa nhập [Ngày đề nghị]");
		document.getElementById("request_date").focus();
		return false;
	}
	

	*/
	

}


function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
	 document.getElementById(divName).style.display='block';
	 
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
	 document.getElementById(divName).style.display='none';
	 window.location = "/sale/";
}


function getitem(){

	document.getElementById("product_name").innerHTML="";
	document.getElementById("qty").value="1";
	document.getElementById("rebate").value="0";
	document.getElementById("saleprice").value="";
	document.getElementById("serial").value="";
	document.getElementById("btnadd").value="Thêm vào";
    
	document.getElementById('sizeid').innerHTML="";
	document.getElementById('unitid').innerHTML="";


	var frm=document.frm;
	if (frm.productid.value.length<4) return false;

	
	var $j = jQuery.noConflict();
	//check login
	$j.ajax({
		type: 'POST',
		url: "/admin/chklogin/",
		cache: false,
		async: false,
	success: function(response){
		if (response=='login'){
			alert("Hệ thống timeout\nVui lòng đăng nhập lại.");
			window.location.href = "/admin/login/?b="+encodeURIComponent("/sale/");
			return;
		}
	}
	});	
	
	
	//add new
	if (frm.serial.value==""){
		$j.ajax({
			data: {
				'productid': frm.productid.value                
			},
			type: 'POST',
			url: "/sale/getitem/",
			dataType : "json",
			cache: false,
			async: false,
		success: function(response){

			document.getElementById("product_name").innerHTML="";
			if (response.result=="yes"){
				
				 document.getElementById("product_name").innerHTML=response.product_name;
				 if (parseFloat(response.saleprice)>0){
					document.getElementById("saleprice").value=formatMoney(response.saleprice);
				 }
				
				
					
					
				if (parseFloat(response.off)>0){
					document.getElementById("rebate").value=formatMoney(response.off);
					$j("#unit_ck1").text("%");
					document.getElementById('chk_unit_ck1').checked=true;
				 }
				
				//size
				if (response.size_total>0){
					if (response.size.length>1)  $j('#sizeid').append('<option value="">Chọn size</option>');
					for (var i =0; i<response.size.length; i++) 
					{
						$j('#sizeid').append('<option value="' + response.size[i].sizeid + '">'+response.size[i].sizename+'</option>');
					}

				}				
				
				//unit
				if (response.unit_total>0){
					if (response.unitdata.length>1) $j('#unitid').append('<option value="">Chọn ĐV</option>');
					for (var i =0; i<response.unitdata.length; i++) 
					{
						$j('#unitid').append('<option value="' + response.unitdata[i].id + '">'+response.unitdata[i].name+'</option>');
					}

				}				
				
			
			}
		}
		});	

		//$j("#btnadd" ).focus();
		//addtemp();
		

	}
	
	

}


function getprice(){


	document.getElementById("saleprice").value="";
	document.getElementById("rebate").value="0";
	var frm=document.frm;

	var $j = jQuery.noConflict();
	//check login
	$j.ajax({
		type: 'POST',
		url: "/admin/chklogin/",
		cache: false,
		async: false,
	success: function(response){
		if (response=='login'){
			alert("Hệ thống timeout\nVui lòng đăng nhập lại.");
			window.location.href = "/admin/login/?b="+encodeURIComponent("/sale/");
			return;
		}
	}
	});	
	


	$j.ajax({
		data: {
			'productid': frm.productid.value,
			'sizeid': frm.sizeid.value
		},
		type: 'POST',
		url: "/sale/getprice/",
		dataType : "json",
		cache: false,
		async: false,
	success: function(response){

		if (parseFloat(response.saleprice)>0){
			document.getElementById("saleprice").value=formatMoney(response.saleprice);
		}
	
	
		if (parseFloat(response.off)>0){
			document.getElementById("rebate").value=formatMoney(response.off);
		}
	}
		
	});	
	
	//$j("#btnadd" ).focus();
	//addtemp();

}


function addtemp(){
	var $j = jQuery.noConflict();
	//check login
	$j.ajax({
		type: 'POST',
		url: "/admin/chklogin/",
		cache: false,
		async: false,
	success: function(response){
		if (response=='login'){
			alert("Hệ thống timeout\nVui lòng đăng nhập lại.");
			window.location.href = "/admin/login/?b="+encodeURIComponent("/sale/");
			return;
		}
	}
	});	
	
	if (document.getElementById("productid").value=="" && document.getElementById("serial").value==""){
		alert("Chưa nhập [Mã sản phẩm]");
		document.getElementById("productid").focus();
		return false;
	}
	
	if (document.getElementById("qty").value==""){
		alert("Chưa nhập [Số lượng]");
		document.getElementById("qty").focus();
		return false;
	}


	if (!IsNumeric(document.getElementById("qty").value.replace( /\,/g, ""))){
		alert("[Số lượng] phải là số");
		document.getElementById("qty").focus();
		return false;

	}



	if (document.getElementById("saleprice").value==""){
		alert("Chưa nhập [Giá bán]");
		document.getElementById("saleprice").focus();
		return false;
	}
	
	if (!IsNumeric(document.getElementById("saleprice").value.replace( /\,/g, ""))){
		alert("[Giá bán] phải là số");
		document.getElementById("saleprice").focus();
		return false;

	}


	var myRadio1 = $j('input[name=type]');
	var type = myRadio1.filter(':checked').val();
	var off_type=0; //tien mat
	if(document.getElementById('chk_unit_ck1').checked)  off_type=1; //%
	
	$j.ajax({
		data: {
			'serial': document.getElementById("serial").value,
			'invoiceid': document.getElementById("invoiceid").value,
			'productid': document.getElementById("productid").value,
			'sizeid': document.getElementById("sizeid").value,
			'unitid': document.getElementById("unitid").value,
			'qty': document.getElementById("qty").value,
			'rebate': document.getElementById("rebate").value,
			'saleprice': document.getElementById("saleprice").value,
			'off_type': off_type,
			'type': type
		},
		type: 'POST',
		url: "/sale/addtemp/",
		cache: false,
		async: false,
	success: function(response){	
		//alert(response);	
		//return;
		
		if (response=="ex"){
			alert("Sản phẩm bạn sửa đã tồn tại trong giỏ hàng.\nVui lòng kiểm tra lại.");
			return false;
		}
		
		if (response=="ok"){

			//document.getElementById("product_name").innerHTML="";
			//document.getElementById("qty").value="1";
			//document.getElementById("saleprice").value="";
			//document.getElementById("productid").value="";

			loadnewdata();
			canceledit();
			document.getElementById("productid").focus();
	
		}

	}
		//alert(response);
	});
	
	

	
	
}



function itemedit(srl){
	var $j = jQuery.noConflict();
	document.getElementById("serial").value=srl;
	document.getElementById("btnadd").value="Cập nhật";
	
	
	$j.ajax({
		data: {
			'serial': srl                
		},
		type: 'POST',
		url: "/sale/getitemedit/",
		dataType : "json",
		cache: false,
	success: function(response){
		//alert(response);
	
		document.getElementById("product_name").innerHTML=response.product_name;
		
		document.getElementById("productid").value=response.model;
		document.getElementById("qty").value=response.qty;
		document.getElementById("rebate").value=response.ck;

		if(response.off_type!=0){ 
			document.getElementById("unit_ck1").innerHTML="%";
			document.getElementById('chk_unit_ck1').checked=true;
		}else{
			document.getElementById("unit_ck1").innerHTML="đ";
			document.getElementById('chk_unit_ck1').checked=false;
		}
		
		document.getElementById("saleprice").value=response.saleprice;


		
		document.getElementById("productid").disabled=true;
		/*document.getElementById("sizeid").disabled=true;
		document.getElementById("unitid").disabled=true;
		document.getElementById("type1").disabled=true;
		document.getElementById("type2").disabled=true;
		*/
		
		if (response.size_total>0){
			if (response.size.length>1)  $j('#sizeid').append('<option value="">Chọn size</option>');
			for (var i =0; i<response.size.length; i++) 
			{
				if (response.size[i].sizeid==response.sizeid)
					$j('#sizeid').append('<option value="' + response.size[i].sizeid + '" selected>'+response.size[i].sizename+'</option>');
				else
					$j('#sizeid').append('<option value="' + response.size[i].sizeid + '">'+response.size[i].sizename+'</option>');
			}

		}
		
		
		//unit
		if (response.unit_total>0){
			if (response.unitdata.length>1) $j('#unitid').append('<option value="">Chọn ĐV</option>');
			for (var i =0; i<response.unitdata.length; i++) 
			{
				if (response.size[i].id==response.unit)
					$j('#unitid').append('<option value="' + response.unitdata[i].id + '" selected>'+response.unitdata[i].name+'</option>');
				else
					$j('#unitid').append('<option value="' + response.unitdata[i].id + '">'+response.unitdata[i].name+'</option>');
			}

		}
		
		
	}
		
		
		
		
	});	


	
}



function loadnewdata(){
	var $j = jQuery.noConflict();	
	$j("#data_table").empty();
	$j("#data_table2").empty();
	
	$j.ajax({
		data: {
			'invoiceid': document.getElementById("invoiceid").value
		},
		type: 'POST',
		url: "/sale/loadtemp/",
		cache: false,
		async: false,
		dataType : "json",
	success: function(response){	
	
	
	
		$j('#data_table').append('<tr><th width="15">Stt</th><th>Model</th><th>Loại</th><th>Size</th><th>Mã lô</th><th>Tên sản phẩm</th><th>Giá bán</th><th>SL</th><th>ĐV</th><th>Giảm</th><th>Thành tiền</th><th>&nbsp;</th></tr>');

		$j('#data_table2').append('<tr><td align="center" width="10%">No</td><td align="center" width="15%">Loại</td><td width="20%" align="center">Giá</td><td align="center" width="15%">SL</td><td align="center" width="15%">CK</td><td align="center">Tổng</td></tr>');
		

		if (response.product!=undefined)
		for(var i=0;i<response.product.length;i++)
		{
			var sizename="";
			if (response.product[i].sizename!=null) sizename=response.product[i].sizename;
			var type="Xuất";
			if (response.product[i].type==2){
				type="Nhập";
			}
			
			
			$j('#data_table').append('<tr><td align="center">'+(i+1)+'</td><td>' + response.product[i].model + '</td><td>' + type+ '</td><td>' + sizename+ '</td><td>&nbsp;</td><td>' + response.product[i].product_name + '</td><td>' + response.product[i].saleprice + '</td><td>' + response.product[i].qty + '</td><td>' + response.product[i].unit_name + '</td><td>' + response.product[i].ck + '</td><td>' + response.product[i].thanhtien + '</td><td align="center"><input type="button" value="Sửa" onclick="itemedit('+response.product[i].serial+');">&nbsp;<input type="button" value="Xóa" onclick="delitem('+response.product[i].serial+');"></td></tr>');
			

			var pdname=response.product[i].model;
			if (sizename!="") pdname=pdname+"/"+sizename;
			pdname=pdname+"/"+response.product[i].product_name;
				
			$j('#data_table2').append('<tr><td align="center">'+(i+1)+'</td><td align="center">' + type+ '</td><td align="center">' + response.product[i].saleprice + '&nbsp;</td><td  align="center">' + response.product[i].qty + '</td><td align="center">' + response.product[i].ck + '</td><td align="right">' + response.product[i].thanhtien + '&nbsp;</td></tr><tr><td colspan="6">'+pdname+'</td></tr>');
			
			
			
		}
		
		
		
		//$j('#data_table').append('<tr bgcolor=\"#AA9FFF\"><td colspan=\"6\" align=\"center\">Tổng</td><td align="center">'+response.tongsl+'</td><td></td><td align="right">'+response.amount_org+'&nbsp;</td><td align="right">'+response.tongck1+'&nbsp;</td><td align="right">'+response.amount_rebate+'&nbsp;</td><td></td></tr>');



		//$j('#data_table2').append('<tr><td align="center" colspan="3">Tổng</td><td align="center">'+response.tongsl+'</td><td></td><td align="right">'+response.amount_rebate+'&nbsp;</td></tr>');
		
		
		
		document.getElementById("tongtien").innerHTML=response.tongtien;
		//document.getElementById("sauck1").innerHTML=response.amount_rebate;
		//document.getElementById("tongck1").innerHTML=response.tongck1;
		caculater();
	}
	});	
}



function canceledit(){
	//var $j = jQuery.noConflict();
	document.getElementById('sizeid').innerHTML="";	
	document.getElementById('unitid').innerHTML="";	
	document.getElementById("product_name").innerHTML="";
	document.getElementById("productid").value="";
	document.getElementById("qty").value="1";
	document.getElementById("rebate").value="0";
	document.getElementById("saleprice").value="";
	
	document.getElementById("productid").disabled=false;
	
	
		
	document.getElementById("serial").value="";
	document.getElementById("btnadd").value="Thêm vào";
	
	document.getElementById('chk_unit_ck1').checked=false;
	document.getElementById("unit_ck1").innerHTML="đ";
		
		
		
		
}



function delitem(srl){
	var $j = jQuery.noConflict();

	var r = confirm("Bạn có chắc chắn xóa không?");
	if (r == true) {
		$j.ajax({
			data: {
				'serial': srl                
			},
			type: 'POST',
			url: "/sale/delitem/",
			cache: false,
		success: function(response){
			
			if (response=="failed"){
				alert("Xóa xẩy ra lỗi, vui lòng thử lại.");
				return false;		
			}
			
			if (response=="ok") loadnewdata();
		}
			
		});	
	
	
	}
	



	
}
	
	
function getcustomer(){
	document.getElementById("phone").value=document.getElementById("customerid").value;
	
	document.getElementById("customer_name").value="";
	document.getElementById("birthday").value="";
	document.getElementById("mail").value="";
	document.getElementById("address").value="";
	document.getElementById("sexf").checked=true;
	document.getElementById("sexm").checked=false;
	document.getElementById("point").innerHTML="";
	document.getElementById("diemsudung").innerHTML="";
	document.getElementById("diemtichluy").innerHTML="";
	document.getElementById("diemdu").innerHTML="";
	document.getElementById("sudungdiem").checked = false;
	document.getElementById("sudungdiem").disabled = true;
	document.getElementById("nocu").innerHTML="0";
	document.getElementById("thanhtoan").value="";
	document.getElementById("nomoi").value="";
	document.getElementById("tongno").innerHTML="0";
	

	if (document.getElementById("customerid").value.length<10) return false;
	
	var $j = jQuery.noConflict();
	$j.ajax({
		data: {
			'customerid': document.getElementById("customerid").value                
		},
		type: 'POST',
		url: "/sale/getcustomer/",
		dataType : "json",
		cache: false,
		async: false,
		success: function(response){

		if (response.result=="yes"){
			document.getElementById("customer_name").value=response["customers"].fullname;
			if (response["customers"].sex==0) document.getElementById("sexf").checked=true;
			if (response["customers"].sex==1) document.getElementById("sexm").checked=true;
			if (response["customers"].birthday!=null) document.getElementById("birthday").value=response["customers"].birthday;
			document.getElementById("mail").value=response["customers"].mail;
			document.getElementById("address").value=response["customers"].address;
			document.getElementById("phone").value=response["customers"].phone;

			if (parseInt(response["customers"].point)>response.point_limit) document.getElementById("sudungdiem").disabled = false;
			document.getElementById("point").innerHTML=response["customers"].point;

			if (response["customers"].tongno!=null){
				document.getElementById("nocu").innerHTML=formatMoney(response["customers"].thucno);
				document.getElementById("thanhtoan").value=formatMoney(response["customers"].thucno);
				document.getElementById("tongno").innerHTML=formatMoney(response["customers"].thucno);
			}
			//caculater();
			$j( "#productid" ).focus();
		}
	}
	});	
	caculater();

}	



function caculater(){
	
	document.getElementById("tiendiem").innerHTML="0";
	
	var tongtien=document.getElementById("tongtien").innerHTML.replace(/,/g, "");
	var ck2=document.getElementById("ck2").value.replace(/,/g, "");
	
	//%
	if(parseFloat(ck2)>0 && document.getElementById('chk_unit_ck2').checked){
		$tongchk=lamtron(parseFloat(tongtien)*parseFloat(ck2)*0.01);
		tongtien=parseFloat(tongtien)-parseFloat($tongchk);
	}
	
	
	//đ
	if(parseFloat(ck2)>0 && document.getElementById('chk_unit_ck2').checked==false){
		tongtien=parseFloat(tongtien)-parseFloat(ck2);
		document.getElementById("ck2").innerHTML=formatMoney(ck2);
	}
		
	//tinh point
	if(document.getElementById('sudungdiem').checked && document.getElementById('point_active').value==1){
		var tmppoint_use = 0;
		var tongsotiendiemcothedung = 0;
		var dupoint = 0;
				
		if (document.getElementById("point_limit").value==0){
			tmppoint_use=document.getElementById("point").innerHTML;
			tongsotiendiemcothedung = parseFloat(tmppoint_use)*parseFloat(document.getElementById("point_one").value);
		}else{
			tmppoint_use = parseFloat(document.getElementById("point").innerHTML) / parseFloat(document.getElementById("point_limit").value);
			tongsotiendiemcothedung = tmppoint_use * parseFloat(document.getElementById("point_one").value) * parseFloat(document.getElementById("point_limit").value);	
		}
		
		if (tongsotiendiemcothedung > tongtien)
		{
			tmppoint_use = lamtron(parseFloat(tongtien) / parseFloat(document.getElementById("point_one").value));
			tongtien = 0;
			dupoint = parseFloat(document.getElementById("point").innerHTML) - tmppoint_use;
			tiendiem=parseFloat(tmppoint_use)*parseFloat(document.getElementById("point_one").value);
			document.getElementById("tiendiem").innerHTML=formatMoney(lamtron(tiendiem));
			document.getElementById("diemsudung").innerHTML=tmppoint_use;
		}
		else
		{
			if (tongsotiendiemcothedung > tongtien)
				tongtien = 0;
			else
				tongtien = tongtien - tongsotiendiemcothedung;

			var diemsudung=lamtron(parseFloat(tongsotiendiemcothedung)/parseFloat(document.getElementById("point_one").value));
			dupoint = parseFloat(document.getElementById("point").innerHTML) - parseFloat(diemsudung);
			tiendiem=parseFloat(tongsotiendiemcothedung)/parseFloat(document.getElementById("point_one").value);
			document.getElementById("tiendiem").innerHTML=formatMoney(lamtron(tongsotiendiemcothedung));
			document.getElementById("diemsudung").innerHTML=diemsudung;
		}
		document.getElementById("diemdu").innerHTML=lamtron(dupoint);	
	}
	
	
	
	//vat
	tongchuavat=lamtron(tongtien);
	document.getElementById("tongchuavat").innerHTML=formatMoney(tongchuavat);

	var tongcovat=tongchuavat;
	var vat_amount=0;
	
	if (document.getElementById("vat").value!=""){
		var vat=document.getElementById("vat").value;		
		
		
		if (parseFloat(vat)>0){
			var vat_amount=lamtron(parseFloat(tongchuavat)*parseFloat(vat)/100);			
			tongcovat=lamtron(parseFloat(tongchuavat)+parseFloat(vat_amount));
			tongtien=parseFloat(tongtien)+parseFloat(vat_amount);
		}
	}		
	
	//document.getElementById("vat_amount").innerHTML=formatMoney(vat_amount);
	document.getElementById("tienvat").innerHTML=formatMoney(vat_amount);
	document.getElementById("amount2").value=tongtien;
	
	
	
	
	//debt
	if(document.getElementById('chkdebtpay').checked){
		var thanhtoan=parseFloat(document.getElementById("thanhtoan").value.replace(/,/g, ""));
		tongtien=parseFloat(tongtien)+parseFloat(thanhtoan);
	}
	
	
	document.getElementById("tongno").innerHTML="0";
	var tongno=parseFloat(document.getElementById("nocu").innerHTML.replace(/,/g, ""));
	if (document.getElementById("nomoi").value!=""){
		tongtien=parseFloat(tongtien)-parseFloat(document.getElementById("nomoi").value.replace(/,/g, ""));
		tongno=tongno+parseFloat(document.getElementById("nomoi").value.replace(/,/g, ""));
		document.getElementById("tongno").innerHTML=formatMoney(tongno);
	}
	
	
	document.getElementById("no").innerHTML=document.getElementById("nomoi").value;
	if (document.getElementById("nomoi").value=="") document.getElementById("no").innerHTML="0";
	
	document.getElementById("tongthanhtoan").innerHTML=formatMoney(lamtron(tongtien));
	//diem tich luy
	if(document.getElementById('point_active').value==1){
		var tenmMonety=parseFloat(document.getElementById("tongthanhtoan").innerHTML.replace(/,/g, ""));
		
		if (document.getElementById("thanhtoan").value!="" && document.getElementById('chkdebtpay').checked)
		if (tenmMonety>parseFloat(document.getElementById("thanhtoan").value.replace(/,/g, "")))
			tenmMonety=tenmMonety-parseFloat(document.getElementById("thanhtoan").value.replace(/,/g, ""));
		else
			tenmMonety=parseFloat(document.getElementById("thanhtoan").value.replace(/,/g, ""))-tenmMonety;
		
		//alert(tenmMonety);
		
		if (document.getElementById("nomoi").value!="") tenmMonety=parseFloat(tenmMonety)+parseFloat(document.getElementById("nomoi").value.replace(/,/g, ""));
		
		 if (parseFloat(tenmMonety) > parseFloat(document.getElementById("point_money").value) || parseFloat(tenmMonety) < -parseFloat(document.getElementById("point_money").value)){
			 var point = parseFloat(tenmMonety) / parseFloat(document.getElementById("point_money").value);
			
			 document.getElementById("diemtichluy").innerHTML=lamtron(point);
		}else{
			 document.getElementById("diemtichluy").innerHTML="0";	 
		}
		 
		
	}


}

function chkck2(vl){
	if (vl.value!="" && !IsNumeric(vl.value.replace( /\,/g, ""))){
		alert("Số nhập vào phải là số");
		vl.value="";
		//return;
	}
	
	if (parseInt(vl.value)>100 && document.getElementById('chk_unit_ck2').checked){
		alert("Chiết khấu không được vượt quá 100%");
		vl.value="";
		//return;		
	}

	autocomma(vl);
	caculater();
}


function chkck3(vl){
	autocomma(vl);
	caculater();
}


function rebatef(vl){
	if (vl.value!="" && !IsNumeric(vl.value.replace( /\,/g, ""))){
		alert("Số nhập vào phải là số");
		vl.value="";
		//return;
	}
	
	if (parseInt(vl.value)>100 && rebate_by_item==0 ){
		alert("Chiết khấu không được vượt quá 100%");
		vl.value="";
		//return;		
	}	
}





function chkvat(vl){
	if (vl.value!="" && !IsNumeric(vl.value.replace( /\,/g, ""))){
		alert("Số nhập vào phải là số");
		vl.value="";
		//return;
	}
	
	if (parseInt(vl.value)>100){
		alert("VAT không được vượt quá 100%");
		vl.value="";
		//return;		
	}

	caculater();
}


function qtyf(vl){
	if (vl.value!="" && !IsNumeric(vl.value.replace( /\,/g, ""))){
		alert("Số nhập vào phải là số");
		vl.value="";
		//return;
	}
}

function ghinof(){
	document.getElementById("nomoi").value=document.getElementById("tongthanhtoan").innerHTML;
	caculater();
}

function thanhtoanf(vl){
	if (vl.value!="" && !IsNumeric(vl.value.replace( /\,/g, ""))){
		alert("Số nhập vào phải là số");
		vl.value="";
		return;
	}
	autocomma(vl)
	caculater();
}

function nomoif(vl){
	if (vl.value!="" && !IsNumeric(vl.value.replace( /\,/g, ""))){
		alert("Số nhập vào phải là số");
		vl.value="";
		//return;
	}
	autocomma(vl)
	caculater();
}

function salepricef(vl){
	if (vl.value!="" && !IsNumeric(vl.value.replace( /\,/g, ""))){
		alert("Số nhập vào phải là số");
		vl.value="";
		//return;
	}
	autocomma(vl)
}



function khachdua(money){
	document.getElementById("pay").value=money;
	payf(money);
}


function payf(vl){
	if (vl=="") return;
	if (vl!="" && !IsNumeric(vl.toString().replace( /\,/g, ""))){
		alert("Số nhập vào phải là số");
		document.getElementById("pay").value="";
		//vl.value="";
		//return;
	}
	autocomma(vl)

	document.getElementById("tralaikhach").innerHTML="";
	document.getElementById("tralaikhach_v").innerHTML="";
	if (document.getElementById("pay").value!=""){
		var tralai=parseFloat(document.getElementById("pay").value.replace( /\,/g, ""))-parseFloat(document.getElementById("tongthanhtoan").innerHTML.replace( /\,/g, ""));	
		document.getElementById("tralaikhach").innerHTML="Trả lại khách: "+formatMoney(tralai)+" đ";
		document.getElementById("tralaikhach_v").innerHTML=formatMoney(tralai)+" đ";
		
	}
}


function change_ck1(){

	if(document.getElementById('chk_unit_ck1').checked) 
		document.getElementById("unit_ck1").innerHTML="%";
	else
		document.getElementById("unit_ck1").innerHTML="đ";
	
}

function change_ck2(){

	if(document.getElementById('chk_unit_ck2').checked) 
		document.getElementById("unit_ck2").innerHTML="%";
	else
		document.getElementById("unit_ck2").innerHTML="đ";
	caculater();
}

function thanhtoanchk(){
	
	if (document.getElementById("thanhtoan").value!="" && !IsNumeric(document.getElementById("thanhtoan").value.replace( /\,/g, ""))){
		alert("Số nhập vào phải là số");
		vl.value="";
		document.getElementById('chkdebtpay').checked=false;
		return;
	}
	caculater();
}


function ghino(){
	
	if (parseFloat(document.getElementById("tongthanhtoan").innerHTML.replace(/,/g, ""))>0){
		document.getElementById("nomoi").value=document.getElementById("tongthanhtoan").innerHTML;
		caculater();
	}
	
}