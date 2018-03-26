<template>
	<table class="tablesaw table-bordered table-hover table" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap data-tablesaw-mode-switch>
		<thead>
			<tr>
			 	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Date</th>
			  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Amount</th>
			  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Status</th>
			  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Actions</th>
			</tr>
		</thead>
		<tbody>
			<payment v-for="(payment, index) in items" :key="payment.id" :data="payment" :machines="machines">
			</payment>
		</tbody>
	</table>
</template>

<script>
	import Payment from "./Payment.vue";
	import collection from '../mixins/collection';

	export default {
		props: ['user'],

		components: { Payment },

		mixins: [collection],

		data() {
			return {
				loading: "",
				machines: []
			};
		},

		created() {
			this.fetch();
		},

		methods: {
			fetch(page) {
				this.loading = "loading";
				axios.get(this.url(page)).then(this.refresh);
				axios.get('/machines/available')
					.then((data) => {
						this.machines = data.data;
					});
			},

			url(page){
				return '/payments/' + this.user;
			},

			refresh(data) {
				this.dataSet = data.data;
				this.items = data.data.data;

				window.scrollTo(0,0);
				this.loading = "";
			},

			triggerChange() {
				this.fetch();
			}
		}	
	}
</script>