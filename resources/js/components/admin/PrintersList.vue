<template>
    <div>
        <v-data-table
            :headers="headers"
            :items="printers"
            :items-per-page="25"
            class="elevation-1"
        >
        <template v-slot:item.actions="{ item }">
            <v-icon
            v-text="'mdi-pencil'"
            @click="formDialog(item)"
            >
            </v-icon>
            <v-icon 
            v-text="'mdi-delete-forever'"
            @click="dialogDelete = true"
            >
            </v-icon>
        </template>
        </v-data-table>
        <v-dialog
            v-model="dialogDelete"
            max-width="290"
        >
            <v-card>
                <v-card-title class="headline">Delete printer</v-card-title>

                <v-card-text>Are you sure that you want to delete this printer?</v-card-text>

                <v-card-actions>
                <v-spacer></v-spacer>

                <v-btn
                    color="error"
                    @click="dialogDelete = false"
                >
                    Delete
                </v-btn>

                <v-btn
                    color="cancel"
                    text
                    @click="dialogDelete = false"
                >
                    Cancel
                </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog
            v-model="dialogFrom"
            max-width="290"
        >
            <v-card>
                <v-card-title class="headline">Delete printer</v-card-title>

                <v-card-text>Are you sure that you want to delete this printer?</v-card-text>

                <v-card-actions>
                <v-spacer></v-spacer>

                <v-btn
                    color="error"
                    @click="dialogDelete = false"
                >
                    Delete
                </v-btn>

                <v-btn
                    color="cancel"
                    text
                    @click="dialogDelete = false"
                >
                    Cancel
                </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
import api from '../../api/printers'
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
          { text: 'Serial number', value: 'serialNumber' },
          { text: 'Invenory number', value: 'inventoryNumber' },
          { text: 'User ID', value: 'uin' },
          { text: 'Action', value: 'actions', sortable: false },
        ],
        printers: [],
        newPrinter: {
            id: '',
            name: '',
            serialNumber: '',
            inventoryNumber: '',
            uin: ''
        },
        dialogDelete: false,
        dialogForm: false
      }
    },
    computed: {
        showAll() {
        api.all()
        .then((response) => {
            this.printers = response.data.data;
        })
        .catch ((error) => {
            console.log(error);
        }); 
        }
    },
    methods: {
        formDialog(item) {
            this.newPrinter = item;
            console.log(this.newPrinter);
        }
    },
    created() {
        this.showAll;
    }
  }
</script>