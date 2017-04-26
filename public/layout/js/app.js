Array.prototype.isEmpty = function(){
	if ( this.length == 0 ){
		return true
	}
	return false
}
Array.prototype.lengthIs = function(length){
	if ( this.length == length ){
		return true
	}
	return false
}

var spanishMessagesJTable = {
	serverCommunicationError: 'Se ha producido un error al comunicarse con el servidor.',
	loadingMessage: 'Cargando...',
	noDataAvailable: '¡Datos no disponibles!',
	addNewRecord: 'Agregar',
	editRecord: 'Editar',
	areYouSure: '¿Estás seguro?',
	deleteConfirmation: 'Este registro se eliminará. ¿Estás seguro?',
	save: 'Guardar',
	saving: 'Guardando',
	cancel: 'Cancelar',
	deleteText: 'Borado',
	deleting: 'Borrando',
	error: 'Error',
	close: 'Cerrar',
	cannotLoadOptionsFor: 'No se pueden cargar las opciones para el campo {0}',
	pagingInfo: 'Mostrando {0}-{1} de {2}',
	pageSizeChangeLabel: 'Numero de filas',
	gotoPageLabel: 'Ir a la Pagina',
	canNotDeletedRecords: 'No se pueden eliminar {0} de {1} registros!',
	deleteProggress: 'Eliminando {0} de {1} registros, Procesando...'
}


function openNewWindow(href,input_reference){
	if(window.location.href == href) return

	var h = (window.innerHeight > 0) ? window.innerHeight : screen.height,
		w = (window.innerWidth > 0) ? window.innerWidth : screen.width,
		x = screen.width/2 - w/2,
		y = screen.height/2 - h/2;
	var win = window.open(href,"", "height="+h+",width="+w+",left="+x+",top="+y);
	win.ASIES_IS_WIN_POPUOT = true
	win.INPUT_REFERENCE = input_reference
}

Models = {
	"Planes" : {
		"messages" : {
			"create" : {
				"success" : "El Plan se ha creado Exitosamente",
				"error" : "Ops. Algo no ha salido bien.",
			},
			"validation" : {
				"multipleSelection" : "Solo debe Seleccionar un plan",
				"notSelection" : "Debe Seleccionar al menos un plan",
				"notSelectCorrectParent" : "Debe Seleccionar el plan correcto",
			}
		},
		"all" : function(cb){
			$.ajax({
				type : "GET",
				url : "/api/planes",
				success : cb,
				error : function(){}
			})
		},
		"treeview" : function(cb){
			function recursive(subplanes){
				var subplan = subplanes.map(function(subplan){
					if ( subplan.subplanes && subplan.subplanes.length > 0 ){
						subplan.subplanes = recursive(subplan.subplanes)
					}
					if ( subplan.ctarea ){
						return {text : subplan.ntarea,icon : subplan.icono,li_attr : { ctarea : subplan.ctarea}}
					}else if ( subplan.cplan ){
						return {text : subplan.nplan,icon : subplan.icono,li_attr : { cplan : subplan.cplan },children:subplan.subplanes}
					}
				})
				return subplan
			}
			$.ajax({
				type : "GET",
				url : "/api/planes",
				success : function(response){

					response = response.map(function(plan){
						if ( plan.subplanes.length > 0 ){
							plan.subplanes = recursive(plan.subplanes)
						}
						return {text : plan.nplan,icon : plan.icono,li_attr : { cplan : plan.cplan },children:plan.subplanes}
					})

					return cb(response);
				},
				error : function(){}
			})
		}
	}
}
