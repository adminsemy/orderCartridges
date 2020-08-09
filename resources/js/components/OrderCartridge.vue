<template>
    <v-card>
        <v-alert type="success" v-model="this.alertSuccess" :dismissible="true">
            {{ this.alertText }}
        </v-alert>
        <v-alert type="error" v-model="this.alertWarning" :dismissible="true">
            {{ this.alertText }}
        </v-alert>
        <v-list-item three-line>
            <v-list-item-content>
                <v-list-item-title class="headline" v-text="printer.name"></v-list-item-title>
                <v-list-item-subtitle v-text="printer.uin"></v-list-item-subtitle>
                <v-list-item-subtitle v-text="printer.serialNumber"></v-list-item-subtitle>
                <v-list-item-subtitle v-text="printer.inventoryNumber"></v-list-item-subtitle>
            <v-data-table 
                    dense
                    :headers="headers"
                    :items="history"
                    :items-per-page="7"
                    :sort-by="'date'"
                    :sort-desc="true"
                    class="elevation-1"
                >
                <template v-slot:item.action="{ item }">
                    <h3 v-if="item.action === 1" >Заказ выполнен</h3>
                    <h3 v-else>Ожидается обработка заказа</h3>
                </template>
                </v-data-table>
                <v-container fluid>
                    <p>Выберите картриджи для заказа</p>
                    <v-checkbox v-for="cartridge in cartridges" v-model="selected"
                        :key="cartridge.id"
                        :label="cartridge.name"
                        :value="cartridge.id"
                    ></v-checkbox>
                </v-container>
            </v-list-item-content>
        </v-list-item>
        <v-card-actions>
            <v-btn text class="warning"
                @click="onSubmitOrder"
                :disabled="disableButtonOrder" 
            >
            Заказать</v-btn>
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
            selected: [],
            alertSuccess: false,
            alertWarning: false,
            alertText: '',
            headers: [
            {
                text: 'id',
                align: 'start',
                sortable: true,
                value: 'id',
            },
            { text: 'Name', value: 'cartridgeName' },
            { text: 'Date', value: 'date' },
            { text: 'Action', value: 'action' },
            ],
        }
    },
    computed: {
        disableButtonOrder () {
            if (this.selected.length === 0) {
                return true;
            } else {
                return false;
            }
        }
    },
    methods: {
        onSubmitOrder () {
            this.alertSuccess = false;
            this.alertWarning = false;
            api.update(this.$route.params.id, this.selected)
            .then((response) => {
                api.findPrinter(this.$route.params.id)
                .then((response) => {
                    this.history = response.data.data.history;
                })
                .catch ((error) => {
                    this.$router.push({ name: '404' });
                });
                this.selected = [];
                if (response.data.message === 'Not order') {
                    this.alertText = 'Order is not completed';
                    this.alertWarning = true;
                } else {
                    this.alertText = 'Order is completed';
                    this.alertSuccess = true;
                }
            })
            .catch((error) => {
                console.log(error);
            });
        }
    },
    created () {
        api.findPrinter(this.$route.params.id)
        .then((response) => {
            this.printer = response.data.data;
            this.cartridges = response.data.data.cartridges;
            this.history = response.data.data.history;
        })
        .catch ((error) => {
            this.$router.push({ name: '404' });
        });
    }    
}
</script>