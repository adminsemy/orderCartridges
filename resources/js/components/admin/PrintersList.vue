<template>
    <div>
        <v-row>
            <v-col>
                <v-btn 
                color="primary"
                @click="formNewDialog()"
                >
                    New Printer
                </v-btn>
            </v-col>
        </v-row>
        <v-data-table
            :headers="headers"
            :items="printers"
            :items-per-page="25"
            class="elevation-1"
        >
        <template v-slot:item.actions="{ item }">
            <v-icon
            v-text="'mdi-pencil'"
            color="green"
            @click="formEditDialog(item)"
            >
            </v-icon>
            <v-icon 
            v-text="'mdi-delete-forever'"
            color="red"
            @click="formDeleteDialog(item)"
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
                    @click="deletePrinter()"
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
            v-model="dialogForm"
            max-width="600"
        >
            <v-card>
                <v-card-title>
                    <span class="headline" v-text="titleForm"></span>
                </v-card-title>

                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12">
                                <v-select
                                v-model="printer.name"
                                :items="brands"
                                filter
                                label="Printers brand"
                                required
                                ></v-select>
                            </v-col>
                            <v-col cols="12" sm="6" md="4">
                                <v-text-field
                                label="Serial number"
                                v-model="printer.serialNumber"
                            ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="4">
                                <v-text-field
                                label="Inventory number"
                                v-model="printer.inventoryNumber"
                            ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                label="UIN"
                                v-model="printer.uin"
                                required
                            ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                <v-spacer></v-spacer>

                <v-btn
                    color="success"
                    @click="savePrinter()"
                >
                    Save
                </v-btn>

                <v-btn
                    color="cancel"
                    text
                    @click="dialogForm = false"
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
import apiBrands from '../../api/brands'
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
        titleForm: 'New printer',
        printer: {
            id: '',
            name: '',
            serialNumber: '',
            inventoryNumber: '',
            uin: ''
        },
        dialogDelete: false,
        dialogForm: false,
        brands: []
      }
    },
    methods: {
        showAll() {
        api.all()
        .then((response) => {
            this.printers = response.data.data;
        })
        .catch ((error) => {
            console.log(error);
        }); 
        },
        formEditDialog(item) {
            this.titleForm = 'Edit this printer';
            this.printer = item;
            this.dialogForm = true;
        },
        formDeleteDialog(item) {
            this.printer = item;
            this.dialogDelete = true;
        },
        formNewDialog() {
            this.titleForm = 'New printer';
            this.printer = {
                id: '',
                name: '',
                serialNumber: '',
                inventoryNumber: '',
                uin: ''
            };
            this.dialogForm = true;
        },
        addNewPrinter() {
            api.new(this.printer)
            .then((response) => {
                this.showAll();
            })
            .catch((error) => {
                console.log(error)
            });
        },
        editPrinter() {
            api.edit(this.printer.id, this.printer)
            .then((response) => {
                this.showAll()
            }).catch((error) => {
                console.log(error)
            })
        },
        deletePrinter() {
            api.delete(this.printer.id)
            .then((response) => {
                this.showAll()
            })
            .catch((error) => {
                console.log
            })
            this.dialogDelete = false;
        },
        savePrinter() {
            if (this.printer.id === '') {
                this.addNewPrinter();
            } else {
                this.editPrinter();
            }
            this.dialogForm = false;
        }
    },
    created() {
        this.showAll();
        apiBrands.name()
        .then((response) => {
            this.brands = response.data.data.sort();
        })
        .catch ((error) => {
            console.log(error);
        });
    }
  }
</script>