<template>
	<chartjs-line :bind="true" :labels="labels" :data="data" datalabel="MYR"></chartjs-line>
</template>

<script>
	export default {
		props: ['machine'],
		data() {
			return {
				data: [],
				labels: []
			};
		},

		created() {
			this.fetch();
		},

		methods: {
			fetch() {
				axios.get('/machines/' + this.machine + '/earnings/chart')
					.then((result) => {
						this.data = result.data.data;
						this.labels = result.data.labels;
					});
			}
		}	
	}
</script>