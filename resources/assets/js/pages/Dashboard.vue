<script>
	export default {
		props: ['isdefaultpassword'],

		data() {
			return {
				bitcoinUSD: 0,
				bitcoinURL: 'https://api.coindesk.com/v1/bpi/currentprice.json',
				bitcoinHistoryURL: 'https://api.coindesk.com/v1/bpi/historical/close.json',
				bitcoinHistoryLoadingClass: 'loading',
				bitcoinChartLabels: [1],
				bitcoinChartData: [1],
			};
		},

		created() {

			if(this.isdefaultpassword)
			{
				Vue.swal({
					title: 'Using default password',
					text: "You are currently using our default password, it is recommended that you change your password immeadiately",
					type: "warning",
					showCancelButton: true,
					confirmButtonText: "Change my password",
				}).then((result) => {
					if(result) {
						window.location = "/user/profile";
					}
				});	
			}

			axios.get('/repeater?url=' + this.bitcoinURL).then( data => {
				this.bitcoinUSD = data.data.bpi.USD.rate_float;
				/*Counter Animation*/
				var counterAnim = $('.counter-anim');
				if( counterAnim.length > 0 ){
					counterAnim.counterUp({ delay: 10,
			        time: 1000});
				}
			});

			axios.get('/repeater?url=' + this.bitcoinHistoryURL).then( result => {
				this.bitcoinChartLabels = Object.keys(result.data.bpi);
				this.bitcoinChartData = Object.values(result.data.bpi);
				
				this.bitcoinHistoryLoadingClass = "";

			});
		}	
	}
</script>