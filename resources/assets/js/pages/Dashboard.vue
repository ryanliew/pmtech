<script>
	export default {
		props: ['isdefaultpassword', 'investor', 'marketing'],

		data() {
			return {
				bitcoinUSD: 0,
				bitcoinURL: 'https://api.coindesk.com/v1/bpi/currentprice.json',
				bitcoinHistoryURL: 'https://api.coindesk.com/v1/bpi/historical/close.json',
				bitcoinHistoryLoadingClass: 'loading',
				bitcoinChartLabels: [1],
				bitcoinChartData: [1],
				milestoneLoadingClass: "loading",
				milestonePercentage: 0,
				milestoneString: "",
				milestoneDescription: "",	
			};
		},

		created() {

			if(this.isdefaultpassword == 1)
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

			axios.get('/user/next-milestone').then( data => {
				this.milestonePercentage = data.data.percentage;
				this.milestoneString = data.data.string;
				this.milestoneDescription = data.data.description;

				this.milestoneLoadingClass = "";
			});
		},

		methods: {
			copyTextToClipboard(text) {
			  var textArea = document.createElement("textarea");

			  // Place in top-left corner of screen regardless of scroll position.
			  textArea.style.position = 'fixed';
			  textArea.style.top = 0;
			  textArea.style.left = 0;

			  // Ensure it has a small width and height. Setting to 1px / 1em
			  // doesn't work as this gives a negative w/h on some browsers.
			  textArea.style.width = '2em';
			  textArea.style.height = '2em';

			  // We don't need padding, reducing the size if it does flash render.
			  textArea.style.padding = 0;

			  // Clean up any borders.
			  textArea.style.border = 'none';
			  textArea.style.outline = 'none';
			  textArea.style.boxShadow = 'none';

			  // Avoid flash of white box if rendered for any reason.
			  textArea.style.background = 'transparent';


			  textArea.value = text;

			  document.body.appendChild(textArea);

			  textArea.select();

			  try {
			    var successful = document.execCommand('copy');
			    var msg = successful ? 'successful' : 'unsuccessful';
			    console.log('Copying text command was ' + msg);
			  } catch (err) {
			    console.log('Oops, unable to copy');
			  }

			  document.body.removeChild(textArea);
			},

			copyMarketing() {
				this.copyTextToClipboard(this.marketing);
				$.toast({
	                heading: 'Success',
	                text: 'Copied the marketing link to clipboard',
	                position: 'top-right',
	                loaderBg: '#fec107',
	                icon: 'success',
	                hideAfter: 3500 
	            }); 

			},

			copyInvestor() {
				this.copyTextToClipboard(this.investor);
				$.toast({
	                heading: 'Success',
	                text: 'Copied the investor link to clipboard',
	                position: 'top-right',
	                loaderBg: '#fec107',
	                icon: 'success',
	                hideAfter: 3500 
	            }); 
			}
		}	
	}
</script>