$(document).ready(function(){
	month=getParameterByName('month');
	year=getParameterByName('year');
	if(!month){
		month=new Date().getMonth();
	}
	if(!year){
		year= new Date().getFullYear();
	}

	var calendar = $('#calendar').calendar({
		day:year+'-'+month+'-01',
		events_source: '/api/events/'+window.location.href.split('/').pop()+'?month='+$("select[name*='month']" ).val()+'&year='+$( "select[name*='year']").val(),
		tmpl_path: "/assets/bootstrap-calendar/tmpls/",
		weekbox:false,
		view:'month',
		views:{
			day: {
				enable: 0
			}
		}
	},
	);
})	
;
function details(id,month,year){
	console.log(month)
	url='/api/details/'+id+'?month='+month+'&year='+year;
	$.get(url,function(data){
		$('.modal-body').html(data);
		var e=$(".exportable").tableExport({
			formats:['xls'],
			position:'top',
			bootstrap:true,
			filename:$('#employee').text()
		}); 
		$('.modal-title').text('Resume de Asistencia');
		$('#details').modal('toggle')
	},'html')
}

function invoice(){
	url='/api/invoice/<?=$employee->id?>?month='+'<?=$mes ?>'+'&year=<?=$year ?>';
	$.get(url,function(data){
		$('.modal-body').html(data);
		var e=$(".exportable").tableExport({
			formats:['xls'],
			position:'top',
			bootstrap:true,
			filename:$('#employee').text()
		}); 
		$('.modal-title').text('Comprobante de Pago');
		$('#details').modal('toggle')
	},'html')
}
