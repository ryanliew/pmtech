<template>
	<chartjs-line :bind="true" :labels="labels" :data="data" datalabel="MYR" :option="option"></chartjs-line>
</template>

<script>
	export default {
		props: ['machine'],
		data() {
			return {
				data: [],
				labels: [],
				option: {
					defaultFontColor: '#fff',
					tooltips: {
						mode: 'nearest'
					},
					legend: {
						labels: {
							fontColor: 'white'
						}
					},
					scales: {
						xAxes: [{
							ticks: {
								fontColor: 'white'
							}
						}],
						yAxes: [{
							ticks: {
								fontColor: 'white'
							}
						}],
					}
				}
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