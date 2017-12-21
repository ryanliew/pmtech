<script>
	export default {
		data() {
			return {
				amountMyr: 0,
				totalDeduction: 0,
				amountCrypto: 1,
				calculating: false,

			};
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