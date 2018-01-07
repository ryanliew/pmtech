<script>
	import { Line, mixins } from 'vue-chartjs';
	const { reactiveProp } = mixins

	export default {
		extends: Line,
		data() {
			return {
				options: {
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
		mixins: [reactiveProp],
		mounted() {
			this.renderChart(this.chartData, this.options)
		}
	}
</script>