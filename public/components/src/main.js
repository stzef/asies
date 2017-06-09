import Vue from 'vue'
import SelectTask from './SelectTask.vue'
import TaskTree from './TaskTree.vue'

var vue_app = new Vue({
	el: '#vue-app',
	components : {
		'select-task' : SelectTask,
		'task-tree' : TaskTree,
	},
	data : {
		productos_minimos : [],
		tiplanes : [],
		planes : [],
		treetask_select : "#treeview_cplan_1",
	},
	watch : {
		planes : function (val,old_val){
		}
	},
	methods: {
		setActiveTaskTree: function (idTaskTree) {
			this.treetask_select = "#treeview_cplan_" + idTaskTree
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
		},
		getTiPlanes: function () {
			var headers =  {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
			fetch("/api/tiplanes",{
				credentials: 'include',
				headers:headers,
				type : "GET",
			}).then((response) => {
				return response.json()
			}).then((tiplanes) => {
				this.tiplanes = tiplanes
			}).catch(err => {

			})

			/*$.ajax({
				type : "GET",
				url : "/api/tiplanes",
				success : (data) => {
					this.tiplanes = data
				}
			})*/

		},
		getPlanes: function () {
			console.warn(this.cplan)
			Models.Planes.treeview(response => {
				this.planes = response
			})
		},
	}
})
