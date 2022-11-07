$(document).ready(function(){
	$("[href='inicio']").addClass('active');
	let idPersonal = '';
	let datos = new FormData();
	datos.append('funcion', 'mostrarAsistenciaMeses');
	datos.append('idPersonal', idPersonal);
	$.ajax({
		url:"ajax/datos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success:function(response){
			console.log("response", response);
			$('#cantidadMeses').html(response['cantidadMeses']);
			new Chart(document.getElementById("sales-chart"), {
			  type: 'line',
			  data: {
			    	labels: response['label'],
			    	datasets: [{ 
				        data: response['datos'],
				        borderColor: 'rgba(60,141,188,0.8)',
				        backgroundColor: 'rgba(60,141,188,0.9)'
			      	}]
			  },
			  options: {
				responsive : true,
				legend:{
					display: false
				},
				scales: {
					xAxes: [{
					  gridLines : {
					    display : false,
					  }
					}],
					yAxes: [{
					  gridLines : {
					    display : false,
					  }
					}]
				},
			    title: {
			      display: true,
			      text: 'Registro de asistencias'
			    }
			  }
			});			
		}
	}); 	
});
