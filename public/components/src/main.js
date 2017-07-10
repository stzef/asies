import Vue from 'vue';
import SelectTask from './SelectTask.vue';
import SelectActivity from './SelectActivity.vue';
import TaskTree from './TaskTree.vue';

new Vue({
	el: '#vue-app',
	components: {
		SelectTask,
		SelectActivity,
		TaskTree,
	},
	data: {
		productos_minimos: [],
		activities: [],
		tiplanes: [],
		planes: [],
		treetask_select: '',
		treetask_cplan: $('#treetask_cplan').val(),
	},
	methods: {
		setActiveTaskTree(idTaskTree) {
			this.treetask_select = '#treeview_cplan_' + idTaskTree;
		},
		getTask() {
			$.ajax({
				type: 'GET',
				url: '/api/tareas',
				success: (data) => {
					this.productos_minimos = data;
				},
			});
		},
		getActivities() {
			$.ajax({
				type: 'GET',
				url: '/api/actividades',
				success: (data) => {
					this.activities = data;
				},
			});
		},
		loadDataTaskTree() {
			this.getPlanes();
			this.getTiPlanes();
		},
		getTiPlanes() {
			var headers = { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') };
			fetch('/api/tiplanes', {
				credentials: 'include',
				headers,
				type: 'GET',
			}).then((response) => {
				return response.json();
			}).then((tiplanes) => {
				this.tiplanes = tiplanes;
			}).catch(err => {

			});

			/* $.ajax({
				type : "GET",
				url : "/api/tiplanes",
				success : (data) => {
					this.tiplanes = data
				}
			}) */
		},
		getPlanes() {
			Models.Planes.treeview((response) => {
				this.planes = response;
			}, this.treetask_cplan);
		},
	},
});
