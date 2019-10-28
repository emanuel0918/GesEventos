var json_s='';nrows_json=0;ncols_json=0;
function BindTable(jsondata, tableid) {/*Function used to convert the JSON array to Html Table*/  
	 var res;
	 json_s='{"registros":[';
	 nrows_json=0;ncols_json=0;
	 var columns = BindTableHeader(jsondata, tableid); /*Gets all the column headings of Excel*/  
	 for (var i = 0; i < jsondata.length; i++) {
	 var row$ = $('<tr/>');
	 for (var colIndex = 0; colIndex < columns.length; colIndex++) { 
		 if(colIndex==0)
			 json_s+='{'
		 var cellValue = jsondata[i][columns[colIndex]];  
		 if (cellValue == null)  
		 cellValue = "";  
		 row$.append($('<td/>').html(cellValue));  
			res = cellValue.includes("\"");
			while(res){
				cellValue=cellValue.replace("\"", "");
				res=cellValue.includes("\"");
			}
		 json_s+='"'+colIndex+'":"'+cellValue+'"';
		 if(colIndex==columns.length-1)
			 json_s+='}';
		 else
			 json_s+=',';
		 if(i==0)
			 ncols_json++;
	 }
	 $(tableid).append(row$);  
	 if(i!=jsondata.length-1)
		json_s+=',';
	 }  
	 json_s+=']}';
	 nrows_json=jsondata.length;
 }  
function BindTableHeader(jsondata, tableid) {/*Function used to get all column names from JSON and bind the html table header*/  
 var columnSet = [];  
 var headerTr$ = $('<tr/>');  
 for (var i = 0; i < jsondata.length; i++) {  
 var rowHash = jsondata[i];  
 for (var key in rowHash) {  
	 if (rowHash.hasOwnProperty(key)) {  
	 if ($.inArray(key, columnSet) == -1) {/*Adding each unique column names to a variable array*/  
		 columnSet.push(key);  
		 headerTr$.append($('<th/>').html(key));  
	 }  
	 }  
 }  
 }  
 $(tableid).append(headerTr$);  
 return columnSet;  
} 
function ExportToTable() {  
	 var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xlsx|.xls)$/;  
	 /*Checks whether the file is a valid excel file*/  
	 if (regex.test($("#excelfile").val().toLowerCase())) {  
	 var xlsxflag = false; /*Flag for checking whether excel is .xls format or .xlsx format*/  
	 if ($("#excelfile").val().toLowerCase().indexOf(".xlsx") > 0) {  
		 xlsxflag = true;  
	 }  
	 /*Checks whether the browser supports HTML5*/  
	 if (typeof (FileReader) != "undefined") {  
		 var reader = new FileReader();  
		 reader.onload = function (e) {  
		 var data = e.target.result;  
		 /*Converts the excel data in to object*/  
		 if (xlsxflag) {  
			 var workbook = XLSX.read(data, { type: 'binary' });  
		 }  
		 else {  
			 var workbook = XLS.read(data, { type: 'binary' });  
		 }  
		 /*Gets all the sheetnames of excel in to a variable*/  
		 var sheet_name_list = workbook.SheetNames;  
  
		 var cnt = 0; /*This is used for restricting the script to consider only first sheet of excel*/  
		 sheet_name_list.forEach(function (y) { /*Iterate through all sheets*/  
			 /*Convert the cell value to Json*/  
			 if (xlsxflag) {  
			 var exceljson = XLSX.utils.sheet_to_json(workbook.Sheets[y]);  
			 }  
			 else {  
			 var exceljson = XLS.utils.sheet_to_row_object_array(workbook.Sheets[y]);  
			 }  
			 if (exceljson.length > 0 && cnt == 0) {  
			 BindTable(exceljson, '#exceltable');  
			 cnt++;  
			 }  
		 });  
		 $('#exceltable').show();  
		 }  
		 if (xlsxflag) {/*If excel file is .xlsx extension than creates a Array Buffer from excel*/  
		 reader.readAsArrayBuffer($("#excelfile")[0].files[0]);  
		 }  
		 else {  
		 reader.readAsBinaryString($("#excelfile")[0].files[0]);  
		 }  
	 }  
	 else {  
		 $.alert({
					title:".",
					content:"El navegador no soporta HTML5",
					type:"red",
					onDestroy:function(){
						
					}
				});   
	 }  
	 }else {   $.alert({
					title:".",
					content:"Ingresa un archivo de Excel valido",
					type:"red",
					onDestroy:function(){
						
					}
				});  
	 }  
 } 
var rgs;
var nombre,rfc;
$( document ).ready(function() {
	 $.alert({
		title:"El funcionamiento correcto para importar el archivo es:",
		content:"Colocar en orden Nombre, Primer Apellido, Segundo Apellido,"
		+" RFC, Escuela, Reconocimiento, Sexo, Discapacidad, Correo, Telefono y Observaciones",
		onDestroy:function(){
			
		}
	});
	$("#formGAL").submit(function(e){
		$("#viewfile").attr("disabled", true);
		e.preventDefault();
		ExportToTable();
		
		$.ajax({
			method:"post",
			url:"./validacion.php",
			cache:false,
			success:function(resp){
				try{
					rgs=JSON.parse(json_s);
					for(index_registro=0;index_registro<nrows_json;index_registro++){
						$.ajax({
							method:"post",
							url:"./altaGalardonado2.php",
							data:{nombre:rgs.registros[index_registro][0],
								primerApe: rgs.registros[index_registro][1],
								segundoApe: rgs.registros[index_registro][2],
								rfc: rgs.registros[index_registro][3],
								escuela: rgs.registros[index_registro][4],
								recon: rgs.registros[index_registro][5],
								sexo: rgs.registros[index_registro][6],
								discapacidad: rgs.registros[index_registro][7],
								correo: rgs.registros[index_registro][8],
								tel: rgs.registros[index_registro][9],
								observaciones: rgs.registros[index_registro][10]},
							cache:false,
							success:function(resp){
							}
						});
					}
				}catch(errorJson){
					
				}
				$.alert({
					title:".",
					content:"Registro ejecutado correctamente",
					type:"green",
					onDestroy:function(){
						
					}
				});
				//$("#viewfile").attr("disabled", false);
				//location.reload();
			}
		});
		
	});
	//$( ".form-recon" ).css( "border-color", "#ff0000" );
});
