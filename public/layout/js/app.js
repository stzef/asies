Models = {
	"Planes" : {
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
				a = subplanes.map(function(subplan){
					if ( subplan.subplanes.length > 0 ){
						subplan.subplanes = recursive(subplan.subplanes)
					}
					return {text : subplan.nplan,li_attr : {},children:subplan.subplanes}
				})
				return a
			}
			$.ajax({
				type : "GET",
				url : "/api/planes",
				success : function(response){

					response = response.map(function(plan){
						if ( plan.subplanes.length > 0 ){
							plan.subplanes = recursive(plan.subplanes)
						}
						return {text : plan.nplan,li_attr : {},children:plan.subplanes}
					})

					return cb(response);
				},
				error : function(){}
			})
		}
	}
}
