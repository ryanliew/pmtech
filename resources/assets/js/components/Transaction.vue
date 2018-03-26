<template>
	<tr>
		<td v-text="transaction.type_name"></td>
		<td v-text="transaction.description"></td>
		<td v-text="transaction.amount"></td>
		<td v-text="transaction.bitcoin_earning" v-if=""></td>
		<td v-text="date"></td>
	</tr>	
</template>

<script>
	import moment from 'moment';
	export default {
		props: ['data'],
		data() {
			return {
				transaction: this.data
			};
		},

		computed: {
			date() {
				return moment(this.transaction.created_at).format('YYYY-MM-DD');	
			},

			bitcoin_value() {
				return this.transaction.bitcoin_earning > 0 ? this.transaction.bitcoin_earning : "-" ;
			}
		}	
	}
</script>