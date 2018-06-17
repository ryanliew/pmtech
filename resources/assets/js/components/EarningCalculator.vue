<script>
	export default {
		props: ['initial_amount','cryptocurrency_amount'],
		data() {
			return {
				amountMyr: this.initial_amount,
				totalDeduction: 0,
				amountCrypto: this.cryptocurrency_amount,
				calculating: false,

			};
		},

		created() {
			if( this.amountMyr > 0 )
			{
				this.getTotalDeduction();
			}
			
		},

		methods: {
			getTotalDeduction() {
				this.calculating = true;
				axios.post('/settings/deductions', { amount: this.amountMyr })
					.then(response => {
						this.totalDeduction = response.data;
						this.calculating = false;
					});
			}
		},

		computed: {
			finalAmount() {
				return this.amountMyr - this.totalDeduction;
			},

			conversionRate() {
				return this.finalAmount / this.amountCrypto;
			}
		}	
	}
</script>