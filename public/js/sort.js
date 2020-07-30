function search_data(s_id){
	
	if (s_id!=undefined){
		var temp=$('#sort_fileds').val();
		if (temp.indexOf(s_id) <= -1)
			temp=s_id+" asc";
		else{
			if (temp.indexOf(s_id+" asc") !== -1) 
				temp=temp.replace(s_id+" asc",s_id+" desc");
			else 
				temp=temp.replace(s_id+" desc",s_id+" asc");
		}
		$('#sort_fileds').val(temp);
	}
	document.getElementById("frm").submit();
}

function sort_data(){
	if ($('#sort_fileds').val()=="") return;
	
	var temp=$('#sort_fileds').val();
	var temp2=temp.split(" ");

	$("#s_"+temp2[0]).removeClass('fa-sort');
	$("#s_"+temp2[0]).removeClass('fa-sort-asc');
	$("#s_"+temp2[0]).removeClass('fa-sort-desc');
	if (temp2[1]=='asc')
		$("#s_"+temp2[0]).addClass('fa-sort-asc');
	else
		$("#s_"+temp2[0]).addClass('fa-sort-desc');
	
	
	/*if ($('#sort_fileds').val()=="") return;
	
	var temp=$('#sort_fileds').val().split(",");
	for (i = 0; i < temp.length; i++) {
		if (temp[i]=="") continue;
		var temp2=temp[i].split(" ");

		$("#s_"+temp2[0]).removeClass('fa-sort');
		$("#s_"+temp2[0]).removeClass('fa-sort-asc');
		$("#s_"+temp2[0]).removeClass('fa-sort-desc');
		if (temp2[1]=='asc')
			$("#s_"+temp2[0]).addClass('fa-sort-asc');
		else
			$("#s_"+temp2[0]).addClass('fa-sort-desc');
	}*/
}