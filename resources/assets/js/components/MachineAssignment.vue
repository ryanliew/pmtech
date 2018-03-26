<template>
	<li class="flex-row flex-center mb-5" v-if="empty_unit_count > 0">
		<div class="flex"><i class="fa fa-server mr-5"></i><span v-text="machine.name"></span> - <span v-text="empty_unit_count"></span> units left</div>
		<div class="mr-10"><input type="number" v-model="amount"></div>
		<button @click="assign" class="btn btn-info" v-if="!assigning">Assign</button>
		<button class="btn btn-info" disabled v-else><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i></button>
	</li>
</template>

<script>
	var globaltest = false;
	export default {
		props: ['machine', 'payment'],
		data() {
			return {
				amount: 0,
				empty_unit_count: 0,
				assigning: false
			};
		},

		created() {
			this.empty_unit_count = this.machine.empty_unit_count.aggregate;
		},

		methods: {
			assign() {
				this.assigning = true;
				axios.post('/payment/' + this.payment + '/unit/assign', {'id': this.machine.id, 'amount': this.amount})
					.catch(error => {
						if(error) flash(error.response.data.errors.amount[0], 'danger');
						this.assigning = false;
					})
					.then(response => {
						if(response) {
							flash('Assigned ' + this.amount + ' units of ' + this.machine.name );
							this.empty_unit_count -= this.amount;
						}
						this.assigning = false;
					});
			}
		}	
	}
</script>