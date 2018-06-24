<template>
	<div>
		<div class="form-group">
			<div class="flex-row">
				<label class="control-label mb-10 mr-10">FILTER BY DATE</label>
				<div class="flex mr-10">
					<vue-slider 
						ref="slider" 
						v-model="value"
						:dotSize="dotSize"
						:interval="interval"
						:piecewise="piecewise"
						:piecewiseLabel="piecewiseLabel"
						:clickable="true"
						tooltip="hover"
						:data="availableDates"
						:piecewiseStyle="piecewiseStyle"
						:labelStyle="labelStyle"
						:piecewiseActiveStyle="piecewiseActiveStyle"
						:labelActiveStyle="labelActiveStyle"
						@input="triggerChange">
				
					</vue-slider>
				</div>
			</div>
		</div>
		<div :class="loading">
			<div class="preloader-block">
				<ul class="spin-preloader">
					<li></li>
					<li></li>
					<li></li>
					<li></li>
				</ul>
			</div>
			<table class="tablesaw table-bordered table-hover table" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap data-tablesaw-mode-switch>
				<thead>
					<tr>
					 	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Type</th>
					  	
					  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Date</th>
					  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Description</th>
					  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Amount</th>
					  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Bitcoin</th>
					</tr>
				</thead>
				<tbody>
					<transaction v-for="(transaction, index) in items" :key="transaction.id" :data="transaction"></transaction>

					<tr v-if="items.length == 0">
						<td colspan="5">No transaction for selected period</td>
					</tr>

					<tr>
						<td colspan="3" class="text-right"><b>Total:</b></td>
						<td>{{ totalAmount | amount }}</td>
						<td>{{ totalBitcoin | bitcoin }}</td>
					</tr>
				</tbody>
			</table>
			<table>
				
			</table>
		</div>
		<paginator :dataSet="dataSet" @changed="fetch"></paginator>
	</div>
</template>

<script>
	import Transaction from './Transaction.vue';
	import collection from '../mixins/collection';
	import vueSlider from 'vue-slider-component';
	import moment from 'moment';

	export default {
		props: ['created_at'],

		components: { Transaction, vueSlider },

		mixins: [collection],

		data() {
			return {
				dataSet: [],
				value: [moment().format("MM-YYYY"), moment().add(1, 'months').format("MM-YYYY") ],
				dotSize: 18,
				interval: 2,
				piecewise: true,
				loading: "",
				piecewiseStyle: {
				  "backgroundColor": "#ccc",
				  "visibility": "visible",
				  "width": "12px",
				  "height": "12px"
				},
				labelStyle: {
					"color": "white"
				},
				piecewiseActiveStyle: {
				  "backgroundColor": "#3498db"
				},
				labelActiveStyle: {
				  "color": "#3498db"
				},
				piecewiseLabel: true
			};
		},

		created() {
			this.fetch();
		},

		methods: {
			fetch(page) {
				this.loading = "loading";
				axios.get(this.url(page)).then(this.refresh);
			},

			url(page){
				if(! page){
					let query = location.search.match(/page=(\d+)/);
					page = query ? query[1] : 1;
				}
				return `${location.pathname}?page=${page}&start=${this.value[0]}&end=${this.value[1]}`;
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
		},

		computed: {
			availableDates() {
				let start = moment(this.created_at);
				let dates = [];

				//console.log(moment().add(1, 'months'));
				do {

					dates.push(start.format("MM-YYYY"));
					start.add(1,'months');
				} while(start.isBefore(moment().add(1, 'months')));

				dates.push(start.format("MM-YYYY"));
				return dates;
			},

			totalAmount()  {
				return _.sumBy(this.items, function(i){
					return i.amount;
				});
			},

			totalBitcoin() {
				return _.sumBy(this.items, function(i){
					return i.bitcoin_earning;
				});
			}
		}	
	}
</script>