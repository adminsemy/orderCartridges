<template>
  <v-data-table
    :headers="headers"
    :items="printers"
    :items-per-page="25"
    class="elevation-1"
  >
  <template v-slot:item.actions="{ item }">
      <router-link :to="{ name: 'order.cartridge', params: { id: item.id } }">Заказать картридж</router-link>
  </template>
  </v-data-table>
</template>
<script>
import api from '../api/printers'
  export default {
    data () {
      return {
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
        printers: []
      }
    },
    created() {
        api.all()
        .then((response) => {
            this.printers = response.data.data;
        })
        .catch ((error) => {
            console.log(error);
        });
    }
  }
</script>