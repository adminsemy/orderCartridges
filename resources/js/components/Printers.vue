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
            text: this.$t('Printers.Id'),
            align: 'start',
            sortable: true,
            value: 'id',
          },
          { text: this.$t('Printers.Name'), value: 'name' },
          { text: this.$t('Printers.Serial_number'), value: 'serialNumber' },
          { text: this.$t('Printers.Invenory_number'), value: 'inventoryNumber' },
          { text: this.$t('Printers.User_ID'), value: 'uin' },
          { text: this.$t('Printers.Action'), value: 'actions', sortable: false },
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