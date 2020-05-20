<template>
    <div>
    <v-alert type="success" v-model="this.alertSuccess" :dismissible="true">
        {{ this.alertText }}
    </v-alert>
    <v-alert type="error" v-model="this.alertWarning" :dismissible="true">
        {{ this.alertText }}
    </v-alert>
    <v-data-table
        :headers="headers"
        :items="orders"
        disable-pagination
        hide-default-footer
        class="elevation-1"
    >
    <template v-slot:item.actions="{ item }">
        <v-btn
            :disabled="item.newCartridge === 0 ? true : false"
            class="success"
            :key="item.id"
            @click="openDialogNew(item.id)"
        >
        New
        </v-btn>
        <v-btn
            class="info"
            :key="item.id"
            @click="dialogSeasoned = true"
        >
        Seasoned
        </v-btn>
        <v-btn
            class="error"
            :key="item.id"
            @click="dialogDelete = true"
        >
        Delete
        </v-btn>
    </template>
    </v-data-table>
    <v-dialog
      v-model="dialogNew.status"
      max-width="290"
    >
      <v-card>
        <v-card-title class="headline">New cartridge</v-card-title>

        <v-card-text>Are you sure that you want to send a new cartridge?</v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn
            color="success"
            @click="giveOutCartridge(newCartridge)"
          >
            Yes
          </v-btn>

          <v-btn
            color="cancel"
            text
            @click="dialogNew.status = false"
          >
            No
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog
      v-model="dialogSeasoned"
      max-width="290"
    >
      <v-card>
        <v-card-title class="headline">Seasoned cartridge</v-card-title>

        <v-card-text>Are you sure that you want to send a seasoned cartridge?</v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn
            color="success"
            @click="dialogSeasoned = false"
          >
            Yes
          </v-btn>

          <v-btn
            color="cancel"
            text
            @click="dialogSeasoned = false"
          >
            No
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog
      v-model="dialogDelete"
      max-width="290"
    >
      <v-card>
        <v-card-title class="headline">Delete order</v-card-title>

        <v-card-text>Are you sure that you want to delete this order?</v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn
            color="success"
            @click="dialogDelete = false"
          >
            Yes
          </v-btn>

          <v-btn
            color="cancel"
            text
            @click="dialogDelete = false"
          >
            No
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    </div>
</template>

<script>
import api from '../../api/order';
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
          { text: 'Date by order', value: 'date' },
          { text: 'Name printer', value: 'printerName' },
          { text: 'Cartridge name', value: 'cartridgeName' },
          { text: 'Get cartridge', value: 'actions', sortable: false },
        ],
        orders: [],
        dialogNew: {
            status: false,
            id: ''
        },
        dialogSeasoned: false,
        dialogDelete: false,
        alertSuccess: false,
        alertWarning: false,
        alertText: '',
        newCartridge: 'new',
        SeasonedCartridge: 'seasoned',
      }
    },
    methods: {
        openDialogNew (id) {
            this.dialogNew.status = true;
            this.dialogNew.id = id;
        },
        findOrder () {
            api.findOrder()
            .then((response) => {
                this.orders = response.data.data;
            })
            .catch ((error) => {
                console.log(error);
                //this.$router.push({ name: '404' });
            });
        },
        giveOutCartridge (cartridge) {
            this.alertSuccess = false;
            this.alertWarning = false;

            api.giveCartridge(this.dialogNew.id, cartridge)
            .then((response) => {
                this.alertText = response.data.message
                if (this.alertText === 'New cartridge was sended') {
                    this.alertSuccess = true;
                } else {
                    this.alertWarning = true;
                }
                this.findOrder();
            }).catch((error) => {
                console.log(error)
            })
            this.dialogNew.status = false;
            this.dialogNew.id = '';
        },
    },
    created () {
        this.findOrder();
    }
}
</script>