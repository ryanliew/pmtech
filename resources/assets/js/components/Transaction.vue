<template>
	<tr>
		<td v-text="transaction.type_name"></td>
		<td v-text="date"></td>
		<td v-text="transaction.description"></td>
		<td>{{ transaction.amount | amount }}</td>
		<td>{{ transaction.bitcoin_earning | bitcoin }}</td>
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