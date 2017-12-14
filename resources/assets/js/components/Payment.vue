<template>
	<tr>
	  	<td class="title" v-text="date"></td>
	  	<td v-text="payment.amount"></td>
	  	<td v-text="status"></td>
	  	<td>
	  		<div class="button-list">
	  			<button class="btn btn-info" v-text="buttonText" @click="approving = true"></button>
				
				<div class="modal vue-modal" role="dialog" v-if="approving">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" @click="approving = false">×</button>
								<h5 class="modal-title" v-text="'Payment #' + payment.id"></h5>
							</div>
							<div class="modal-body">
								<img :src="payment.payment_slip_path" class="img-responsive">
								<div class="flex-row flex-center mt-10">
									<label for="amount" class="control-label mr-10">Amount</label>
									<input class="form-control" type="text" v-model="amount">
								</div>	
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" @click="approving = false">Close</button>
								<button type="button" class="btn btn-danger" v-if="!payment.is_verified" @click="approve">Verify payment</button>
							</div>
						</div>
					</div>
				</div>

				<button class="btn btn-info" @click="assigning = true" v-if="!payment.unit_id && payment.is_verified">Assign unit</button>
				
				<div class="modal vue-modal" role="dialog" v-if="assigning">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" @click="assigning = false">×</button>
								<h5 class="modal-title" v-text="'Payment #' + payment.id"></h5>
							</div>
							<div class="modal-body">
								<div class="flex-row">
									<div class="mr-15">Amount: <span v-text="amount"></span></div>
									<div>Machine: <span v-text="assignedMachineName"></span></div>
								</div>
								<ul>
									<li class="flex-row flex-center" v-for="(machine, index) in machines" :key="machine.id">
										<div class="flex"><i class="fa fa-server mr-5"></i><span v-text="machine.name"></span></div>
										<div><button class="btn btn-info" @click="assign(machine)">Assign machine</button></div>
									</li>
								</ul>	
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" @click="assigning = false">Close</button>
								<button type="button" class="btn btn-danger" @click="confirmAssign">Confirm assign</button>
							</div>
						</div>
					</div>
				</div>
			</div>
	  	</td>
	</tr>
</template>

<script>
	import moment from 'moment';
	export default {
		props: ['data', 'machines'],
		data() {
			return {
				payment: this.data,
				approving: false,
				assigning: false,
				assignedMachineID: false,
				assignedMachineName: '',
				amount: 0
			};
		},

		created() {
			this.amount = this.data.amount;
		},

		methods: {
			approve() {
				axios.post('/payment/' + this.payment.id, {'amount': this.amount})
					.catch(error => {
						flash("Something went wrong, please try again later", 'danger');
					})
					.then(({data}) => {
						this.payment.is_verified = true;
						this.approving = false;
						this.assigning = true;
						this.payment.amount = this.amount;
						flash('Payment approved');
					});
			},

			assign(machine) {
				this.assignedMachineID = machine.id;
				this.assignedMachineName = machine.name;
			},

			confirmAssign() {
				axios.post('/payment/' + this.payment.id + '/unit/assign', {'id': this.assignedMachineID})
					.catch(error => {
						flash("Something went wrong, please try again later", 'danger');
					})
					.then(({data}) => {
						this.payment.unit_id = this.assignedMachineID;
						this.assigning = false;
						flash('Unit assign successful');
					});
			},
		},

		computed: {
			date() {
				return moment(this.payment.created_at).format('YYYY-MM-DD');	
			},

			status() {
				return this.payment.unit_id ? "Assigned" : this.payment.is_verified ? "Verified" : "Pending";
			},

			buttonText() {
				return this.payment.is_verified ? "View" : "Verify";
			}
		}		
	}
</script>