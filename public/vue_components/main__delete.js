var selectTask = {
	template: `<select :name="name" :id="id" class="form-control">
					<optgroup v-for="producto_minimo in productos_minimos" :label="producto_minimo.nplan">
						<template v-for="tarea in producto_minimo.tareas" >
							<option :value="tarea.ctarea"> {{ tarea.ntarea }} </option>
						</template>
					</optgroup>
				</select>`,
	props: {
		name: {type : String,},
		id: {type : String,},
		productos_minimos: {type: Array,}
	},
	mounted :function(){this.$emit("mounted")}
}
var taskTree = {
	template: `<div class="row">
					<table class="table">
						<tr>
							<template v-for="tiplan in tiplanes">
								<td>
									<img :src="'/'+tiplan.icono" alt="">
									<label>{{ tiplan.ntiplan }}</label>
								</td>
							</template>
						</tr>
					</table>
					<div class="col-md-12">
						<div class="panel panel-default">

							<div class="panel-body">

								<ul class="nav nav-tabs">
									<template v-for="plan in planes">
										<li @click="changeSelectTaskTree(plan.li_attr.cplan)" :data-treeview="'#treeview_cplan_' + plan.li_attr.cplan"><a data-toggle="tab" :href="'#cplan_'+plan.li_attr.cplan">{{ plan.text }}</a></li>
									</template>
								</ul>

								<input type="text" id="treeview_find" value="" placeholder="Buscar..." class="input" style="margin:0em auto 1em auto; display:block; padding:4px; border-radius:4px; border:1px solid silver;">

								<div class="tab-content">
									<template v-for="plan in planes">
										<div :id="'cplan_' + plan.li_attr.cplan" class="tab-pane fade in active" :data-treeview="'#treeview_cplan_' + plan.li_attr.cplan">
											<div :id="'treeview_cplan_' + plan.li_attr.cplan"></div>
										</div>
									</template>
								</div>
							</div>
						</div>
					</div>
				</div>`,
	props: {
		tiplanes: {type: Array,},
		planes: {type: Array,},
	},
	methods : {
		changeSelectTaskTree : function(id){
			console.info(id)
			this.$emit("ctt",id)
		}
	},
	mounted :function(){this.$emit("tt_mounted")}
}


var vue_app = new Vue({
	el: '#vue-app',
	components : {
		'select-task' : selectTask,
		'task-tree' : taskTree,
	},
	data : {
		productos_minimos : [],
		tiplanes : [],
		planes : [],
		treetask_select : "#treeview_cplan_1",
	},
	watch : {
		planes : function (val,old_val){
			for ( var plan of val ){
				var select_treeview = "#treeview_cplan_"+plan.li_attr.cplan
				console.log($(select_treeview))
				$(select_treeview).jstree({
					"plugins" : [ "search" , "contextmenu", "types"],
					"types" : {
						"modulo" : {
							"icon" : "/vendor/jstree/img/module.png"
						},
						"tareas" : {
							"icon" : "/vendor/jstree/img/task.png"
						},
						"componente" : {
							"icon" : "/vendor/jstree/img/component.png"
						},
						"elemento" : {
							"icon" : "/vendor/jstree/img/element.png"
						},
						"prod_minimo" : {
							"icon" : "/vendor/jstree/img/product.png"
						},
					},
					'core' : { 'data' : plan },
				})
			}
			var to = false;
			$('#treeview_find').keyup(function () {
				if(to) { clearTimeout(to); }
				to = setTimeout(function () {
					var v = $('#treeview_find').val();
					$(vue_app.treetask_select).jstree(true).search(v);
				}, 250);
			});
		}
	},
	methods: {
		setActiveTaskTree: function (idTaskTree) {
			console.log(idTaskTree)
			vue_app.treetask_select = "#treeview_cplan_" + idTaskTree
			console.log(this.treetask_select)
		},
		getTask: function () {
			$.ajax({
				type : "GET",
				url : "/api/tareas",
				success : (data) => {
					this.productos_minimos = data
				}
			})
		},
		loadDataTaskTree:function(){
			this.getPlanes()
			this.getTiPlanes()
			console.log('Hola')
		},
		getTiPlanes: function () {
			$.ajax({
				type : "GET",
				url : "/api/tiplanes",
				success : (data) => {
					this.tiplanes = data
				}
			})
		},
		getPlanes: function () {
			Models.Planes.treeview(response => {
				this.planes = response
			})
		},
	}
})
