<template>
	<tr>
		<td v-text="transaction.type_name"></td>
		<td v-text="transaction.description"></td>
		<td v-text="transaction.amount"></td>
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
			}
		}	
	}
</script>