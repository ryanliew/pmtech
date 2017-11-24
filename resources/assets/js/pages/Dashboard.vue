<script>
	export default {
		data() {
			return {
				bitcoinUSD: "Updating",
				bitcoinURL: 'https://api.coindesk.com/v1/bpi/currentprice.json'
			};
		},

		created() {
			axios.get('/repeater?url=' + this.bitcoinURL).then( data => {
				this.bitcoinUSD = data.data.bpi.USD.rate_float;
			});
		}	
	}
</script>