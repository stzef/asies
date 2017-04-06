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
					if ( subplan.subplanes.length > 0 ){
						subplan.subplanes = recursive(subplan.subplanes)
					}
					return {text : subplan.nplan,icon : subplan.icono,li_attr : {},children:subplan.subplanes}
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
						return {text : plan.nplan,icon : plan.icono,li_attr : {},children:plan.subplanes}
					})

					return cb(response);
				},
				error : function(){}
			})
		}
	}
}
