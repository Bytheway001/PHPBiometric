<script type="text/javascript" src='/assets/js/bootstrap-year-calendar.js'></script>
<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-year-calendar/1.1.1/js/languages/bootstrap-year-calendar.es.js'></script>

<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.3/moment.min.js'></script>
<style type="text/css">

</style>
<script type="text/javascript">
	function deleteEvent(parameter){
		$.get('/feriados/delete/'+parameter.id,function(){
			
		})
	}

	function addFeriado(){
		var from=$('#from').val();
		var to=$('#to').val();
		var motivo=$('#motivo').val();
		var tipo=$('#tipo').val();
		var employee=$('#employee_id').val()

		$.post('/feriados/add',{start:from,motivo:motivo,tipo:tipo,end:to,employee_id:employee},function(data){
			data.startDate=new Date(data.startDate).getTime()
			data.endDate=new Date(data.endDate).getTime()
			console.log(data)
			$('#calendar').data('calendar').addEvent(data);
			$('.modal').modal('hide')
		})

	}
	function getFeriados(){
		var feriados= [];
		$.ajax({
			url: '/feriados/json',
			success: function (response) {
				console.log(response)
				for (var i = 0; i < response.length; i++) {
					feriados.push({
						id: response[i].id,
						name: response[i].name,
						startDate: new Date(response[i].startDate),
						endDate: new Date(response[i].endDate),
						color: response[i].color,
					});
				}
				$('#calendar').calendar({
					language:'es',
					style:'border',
					enableRangeSelection:true,
					selectRange:function(e){
						var start=moment(e.startDate)
						var end=moment(e.endDate)
						console.log(e)
						$("#from_display").text(start.format('DD-MM-YYYY'))
						$("#from").val(start.format('YYYY-MM-DD'))
						$("#to_display").text(end.format('DD-MM-YYYY'))
						$("#to").val(end.format('YYYY-MM-DD'))
						$('.modal').modal('show')
					},
					enableContextMenu:true,
					dataSource:feriados,
					contextMenuItems:[{text: 'Eliminar',click: deleteEvent}],
					mouseOnDay: function(e) {
						if(e.events.length > 0) {
							var content = '';

							for(var i in e.events) {
								content += '<div class="event-tooltip-content"">'
								+ '<div class="event-name" style="color:white"><i class="fa fa-circle" style="color:'+e.events[i].color+'"></i>'+ e.events[i].name + '</div>'
								+ '</div>';
							}
							$(e.element).popover({ 
								trigger: 'manual',
								container: 'body',
								html:true,
								content: content
							});

							$(e.element).popover('show');
						}
					},
					mouseOutDay: function(e) {
						if(e.events.length > 0) {
							$(e.element).popover('hide');
						}
					},
					clickDay:function(e){
						
					},

				});

			}
		},'JSON');
	}

	$(document).ready(function(){
		getFeriados()



	})

	function permiso(value){
		if (value=="PERMISO"){
			$('#employee_id').prop('disabled',false)
		}
		else{
			$('#employee_id').prop('disabled',true)
		}
	}
</script>
<div class="container-fluid view">
	<div class="row">

		<div class="panel panel-login">	
			<div class="panel-body">
			<div class="col-sm-12">
				<div id="calendar" class='calendar'></div>
			</div>
			</div>
		</div>
	</div>

	<div class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Agregar Feriado</h4>
				</div>
				<div class="modal-body">
					<div class="col-sm-6">
						<div class="form-group">
						<label for="fecha">Desde:</label>
						<p id='from_display'></p>
						<input class='form-control input-sm' type="hidden" id='from' readonly>
					</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
						<label for="fecha">Hasta:</label>
						<p id='to_display'></p>
						<input class='form-control input-sm' type="hidden" id='to' readonly>
					</div>
					</div>
					
					<div class="form-group">
						<label>Motivo</label>
						<input class='form-control input-sm' type="text" id='motivo'>
					</div>
					<div class="form-group">
						<label>Tipo</label>
						<select class='form-control input-sm' id='tipo' onchange='permiso($(this).val())' required>
							<option selected disabled>Seleccione...</option>
							<option value='PERMISO'>Permiso de empleado</option>
							<option value='NACIONAL'>Feriado Nacional</option>
							<option value='EMPRESA'>Feriado De la Empresa</option>
							<option value='ESTADAL'>Feriado Estadal</option>
							<option value='OTRO'>Otros</option>
						</select>
					</div>
					<div class="form-group">
						<label>Empleado</label>
						<select class='form-control input-sm' id='employee_id' disabled>
							<?php foreach(\Employee::all(['select'=>'id, nombres, apellidos']) as $e): ?>
								<option value="<?= $e->id ?>"><?= $e->nombres.' '.$e->apellidos ?></option>
							<?php endforeach; ?>
						</select>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" onclick='addFeriado()' class="btn btn-primary">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</div>
</div>