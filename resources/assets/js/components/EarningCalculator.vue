<script>
	export default {
		data() {
			return {
				amountMyr: 0,
				totalDeduction: 0,
				calculating: false
			};
		},

		methods: {
			getTotalDeduction() {
				this.calculating = true;
				axios.post('/settings/deductions', { amount: this.amount })
					.then(response => {
						this.totalDeduction = response.data;
						this.calculating = false;
					});
			}
		},

		computed: {
			finalAmount() {
				return this.amountMyr - this.totalDeduction;
			}
		}	
	}
</script>