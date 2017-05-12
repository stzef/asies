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
String.prototype.set = function(key,value){
	var reg = new RegExp(key,"g")
	return this.replace(reg,value)
}
String.prototype.truncate = function(len,end){
	if ( len > this.length ){
		return this
	}else{
		var substr = this.substr(0,len)
		end = end ? end : "..."
		var trunc = substr + end
		return trunc
	}
	return this.replace(reg,value)
}

function callbackSuccessAjax(response){
	console.log(response)
		alertify.success("Listo.")
}
function callbackErrorAjax(response){
	responseJSON = response.responseJSON
	if ( responseJSON.errors_form ){
		alertify.error("Ha Ocurrido un Error")
	}
	console.log(response)
}

var DTspanish = {
	"sProcessing":     "Procesando...",
	"sLengthMenu":     "Mostrar _MENU_ registros",
	"sZeroRecords":    "No se encontraron resultados",
	"sEmptyTable":     "Ningún dato disponible en esta tabla",
	"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
	"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
	"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
	"sInfoPostFix":    "",
	"sSearch":         "Buscar:",
	"sUrl":            "",
	"sInfoThousands":  ",",
	"sLoadingRecords": "Cargando...",
	"oPaginate": {
		"sFirst":    "Primero",
		"sLast":     "Último",
		"sNext":     "Siguiente",
		"sPrevious": "Anterior"
	},
	"oAria": {
		"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
		"sSortDescending": ": Activar para ordenar la columna de manera descendente"
	}
}

function serializeForm(form){
	var formData = new FormData(form);
	$(form).find('input[type=file]').each(function(i, file) {
		$.each(file.files, function(n, file) {
			formData.append('file-'+i, file);
		})
	})
	$(form).find('input[type=checkbox]').each(function(i, input) {
		var value = input.checked ? 1 : 0
		formData.append(input.name,value);
	})
	return formData
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

$("[data-find-task]").click(function(event){
	var selector = $(this).data("input-reference")
	openNewWindow("/utilities/tasktree",selector)
})
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
	"Utils" : {
		"dataToTreeview" : function(planes){
			function recursive(subplanes){
				var subplan = subplanes.map(function(subplan){
					if ( subplan.subplanes && subplan.subplanes.length > 0 ){
						subplan.subplanes = recursive(subplan.subplanes)
					}
					if ( subplan.ctarea ){
						var valor = subplan.ifhecha == "1" ? subplan.valor_tarea : 0
						return {
							text : subplan.ntarea + "(" + valor + ")",
							//icon : subplan.icono,
							li_attr : {
								ctarea : subplan.ctarea,
								valor : valor,
							},
							type:"tareas"
						}
					}else if ( subplan.cplan ){
						return {
							text : subplan.nplan + "(" + subplan.valor_plan + "/"+subplan.valor_total+")",
							//icon : subplan.icono,
							li_attr : {
								cplan : subplan.cplan,
								valor : subplan.valor_plan,
							},
							type:subplan.tiplan.slug,
							children:subplan.subplanes
						}
					}
				})
				return subplan
			}
			planes = planes.map(function(plan){
				if ( plan.subplanes.length > 0 ){
					plan.subplanes = recursive(plan.subplanes)
				}
				return {
					text : plan.nplan + "("+plan.valor_plan+"/"+plan.valor_total+")",
					//icon : plan.icono,
					state : {
						opened : true,
					},
					li_attr : {
						cplan : plan.cplan,
						valor : plan.valor_plan,
						"select_treeview":"treeview___cplan__".set("__cplan__",plan.cplan)
					},
					type : plan.tiplan.slug,
					children:plan.subplanes
				}
			})
			return planes
		}
	},
	"Evidencias" : {
		"set" : function(key,data,cb){
			$.ajax({
				type : "PUT",
				url : "/api/evidencias/"+key+"/set",
				contentType:"application/json",
				success : cb,
				data : data,
				error : function(){}
			})
		}
	},
	"Tareas" : {
		cambiarEstado : function(ctarea,ifhecha){
			var ifhecha = ifhecha ? 1 : 0
			var base_url_cambio_estado_tarea = "/tareas/__ctarea__/change_state"
			$.ajax({
				url : base_url_cambio_estado_tarea.set("__ctarea__",ctarea),
				type : "POST",
				data : { ctarea : ctarea, ifhecha : ifhecha },
				success : function(response){
					var textEstado = response.hecha == 1 ? "Hecha" : "No Hecha"
					if ( response.ok ){
						alertify.success("El Estado se ha Cambiado <br> Estado Actual : <b>__estado__</b>".set("__estado__",textEstado))
					}else{
						alertify.warning(response.message)
					}
				},
				error : function(response){},
			})
		}
	},
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
		"findOne" : function(key,cb){
			$.ajax({
				type : "GET",
				url : "/api/planes/"+key,
				success : cb,
				error : function(){}
			})
		},
		"all" : function(cb){
			$.ajax({
				type : "GET",
				url : "/api/planes",
				success : cb,
				error : function(){}
			})
		},
		"recalcular" : function(cb){
			waitingDialog.show('Recalculando Puntos',{onHide: function () {alertify.success('Puntos Recalculados')}});
			$.ajax({
				type:"POST",
				url:"/planes/recalcular",
				success:function(response){
					waitingDialog.hide();
					cb(response)
					console.log(arguments)
				},
				error : function(){
					waitingDialog.hide();
				}
				})
		},
		"treeview" : function(cb){
			$.ajax({
				type : "GET",
				url : "/api/planes",
				success : function(response){
					var data = Models.Utils.dataToTreeview(response)
					return cb(data);
				},
				error : function(){}
			})
		}
	}
}

/**
 * Module for displaying "Waiting for..." dialog using Bootstrap
 *
 * @author Eugene Maslovich <ehpc@em42.ru>
 */

/*
 * Usage
	waitingDialog.show('Dialog with callback on hidden',{onHide: function () {alert('Callback!');}});
*/
var waitingDialog = waitingDialog || (function ($) {
    'use strict';

	// Creating modal dialog's DOM
	var $dialog = $(
		'<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
		'<div class="modal-dialog modal-m">' +
		'<div class="modal-content">' +
			'<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
			'<div class="modal-body">' +
				'<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
			'</div>' +
		'</div></div></div>');

	return {
		/**
		 * Opens our dialog
		 * @param message Custom message
		 * @param options Custom options:
		 * 				  options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
		 * 				  options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
		 */
		show: function (message, options) {
			// Assigning defaults
			if (typeof options === 'undefined') {
				options = {};
			}
			if (typeof message === 'undefined') {
				message = 'Loading';
			}
			var settings = $.extend({
				dialogSize: 'm',
				progressType: '',
				onHide: null // This callback runs after the dialog was hidden
			}, options);

			// Configuring dialog
			$dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
			$dialog.find('.progress-bar').attr('class', 'progress-bar');
			if (settings.progressType) {
				$dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
			}
			$dialog.find('h3').text(message);
			// Adding callbacks
			if (typeof settings.onHide === 'function') {
				$dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
					settings.onHide.call($dialog);
				});
			}
			// Opening dialog
			$dialog.modal();
		},
		/**
		 * Closes dialog
		 */
		hide: function () {
			$dialog.modal('hide');
		}
	};

})(jQuery);
