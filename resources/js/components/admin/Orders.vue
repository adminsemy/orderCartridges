<template>
    <v-data-table
        :headers="headers"
        :items="printers"
        disable-pagination
        hide-default-footer
        class="elevation-1"
    >
    <template v-slot:item.actions="{ item }">
        <v-btn
            class="success"
        >

        </v-btn>
    </template>
    </v-data-table>
</template>

<script>
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
          { text: 'Date by order', value: 'dateByOrder' },
          { text: 'Name printer', value: 'name' },
          { text: 'Cartridge name', value: 'cartridgeName' },
          { text: 'Action', value: 'actions', sortable: false },
        ],
        printers: []
      }
    },
}
</script>