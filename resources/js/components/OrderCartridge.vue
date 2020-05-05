<template>
    <v-card>
    <v-list-item three-line>
      <v-list-item-content>
        <v-list-item-title class="headline mb-1" v-text="printer.name"></v-list-item-title>
        <v-list-item-subtitle v-text="printer.uin"></v-list-item-subtitle>
        <v-list-item-subtitle v-text="printer.serialNumber"></v-list-item-subtitle>
        <v-list-item-subtitle v-text="printer.inventoryNumber"></v-list-item-subtitle>
       
      </v-list-item-content>
    </v-list-item>
    <v-card-actions>
      <v-btn text class="warning">Заказать</v-btn>
    </v-card-actions>
  </v-card>
</template>
<script>
import api from '../api/order';
export default {
    data () {
        return {
            printer: {
                name: '',
                serialNumber: '',
                inventoryNumber: '',
                uin: '',
            },
            history: [],
            cartridges: [],
            headers: [
            {
                text: 'id',
                align: 'start',
                sortable: true,
                value: 'id',
            },
            { text: 'Name', value: 'name' },
            { text: 'Fat (g)', value: 'serialNumber' },
            { text: 'Carbs (g)', value: 'inventoryNumber' },
            { text: 'Protein (g)', value: 'uin' },
            { text: 'Action', value: 'actions', sortable: false },
            ],
        }
    },
    created () {
        api.findPrinter(this.$route.params.id)
        .then((response) => {
            this.printer = response.data.data;
        })
        .catch ((error) => {
            this.$router.push({ name: '404' });
        });
    }    
}
</script>