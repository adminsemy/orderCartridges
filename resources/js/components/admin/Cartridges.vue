<template>
  <div>
    <!-- Button for modal form 'dialogForm' -->
    <v-row>
      <v-col>
        <v-btn color="primary" @click="formNewDialog()">{{ $t('Cartridges.New_cartridge') }}</v-btn>
      </v-col>
    </v-row>
    <!-- Table brands -->
    <v-data-table
      min-height="100%"
      :headers="headers"
      fixed-header
      :items="cartridges"
      :items-per-page="25"
      :sort-by="'name'"
      class="elevation-1"
    >
    <!-- Column 'cartridge' -->
      <template v-slot:item.brands="{ item }">
        <p class="px-3 pt-3" v-if="item.brands.length === 0">No data on brands</p>
        <ul class="py-3" v-if="item.brands.length !== 0">
          <li v-for="brand in item.brands" :key="brand.id">{{ brand.name }}</li>
        </ul>
      </template>
      <!-- Column action with action icons -->
      <template v-slot:item.actions="{ item }">
        <v-icon
          v-text="'mdi-pencil'"
          :title="$t('Cartridges.Edit_cartridge')"
          color="green"
          @click="formEditDialog(item)">
        </v-icon>
        <v-icon
          v-text="'mdi-delete-forever'"
          :title="$t('Cartridges.Delete_cartridge')"
          color="red"
          @click="formDeleteDialog(item)">
        </v-icon>
      </template>
    </v-data-table>
    <!-- Modal form for delete selected brand -->
    <v-dialog v-model="dialogDelete" max-width="290">
      <v-card>
        <v-card-title class="headline">{{ $t('Cartridges.Delete_title') }}</v-card-title>

        <v-card-text>{{ $t('Cartridges.Delete_text') }}</v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn color="error" @click="deleteCartridge()">{{ $t('Cartridges.Delete') }}</v-btn>

          <v-btn color="cancel" text @click="dialogDelete = false">{{ $t('Cartridges.Cancel') }}</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <!-- Modal form for new brand and edit brand with brands -->
    <v-dialog v-model="dialogForm" max-width="600">
      <v-card>
        <v-card-title>
          <span class="headline" v-text="titleForm"></span>
        </v-card-title>

        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="cartridge.name"
                  :label="cartridge.name === '' ? $t('Cartridges.New_name') : $t('Cartridges.Edit_name')"
                  required>
                </v-text-field>
              </v-col>
            </v-row>
            <!-- View brands for selected brand if it's not new brand -->
            <div v-if="cartridge.id !== ''">
              <v-row>
                <v-col cols="10">
                  <v-divider class="mx-3"></v-divider>
                  <v-select
                    v-model="selectBrand"
                    :items="nameBrands"
                    :label="$t('Cartridges.Select_brand')"
                    id="id"
                    item-text="name"
                    return-object="true"
                  ></v-select>
                </v-col>
                <v-col cols="2">
                  <v-btn icon @click="addBrand()" class="ml-4 mt-3">
                    <v-icon color="green">mdi-plus-circle</v-icon>
                  </v-btn>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12">
                  <v-list-item-group color="primary">
                    <v-list-item v-for="(brand, index) in cartridge.brands" :key="brand.id" v-on="prevent">
                      <v-list-item-content>
                        <v-list-item-title v-text="brand.name"></v-list-item-title>
                      </v-list-item-content>

                      <v-list-item-action>
                        <v-btn icon @click="deleteBrand(index)">
                          <v-icon color="red">mdi-delete-circle</v-icon>
                        </v-btn>
                      </v-list-item-action>
                    </v-list-item>
                  </v-list-item-group>
                </v-col>
              </v-row>
            </div>
          </v-container>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn color="success" @click="saveCartridge()">{{ $t('Cartridges.Save') }}</v-btn>

          <v-btn color="cancel" text @click="dialogForm = false">{{ $t('Cartridges.Cancel') }}</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
import apiBrands from "../../api/brands";
import api from "../../api/cartridges";
export default {
  data() {
    return {
      headers: [
        {
          text: "id",
          align: "start",
          value: "id",
        },
        { text: this.$t('Cartridges.Name'), value: "name" },
        { text: this.$t('Cartridges.Brands'), value: "brands", sortable: false },
        { text: this.$t('Cartridges.All'), value: "all", sortable: false },
        { text: this.$t('Cartridges.Ordered'), value: "ordered", sortable: false },
        { text: this.$t('Cartridges.Actions'), value: "actions", sortable: false },
      ],
      cartridges: [],
      titleForm: this.$t('Cartridges.New_cartridge'),
      nameBrands: [],
      selectBrand: '',
      cartridge: {
        id: "",
        name: "",
        brands: [],
      },
      dialogDelete: false,
      dialogForm: false,
    };
  },
  methods: {
    /* Recieve 'id' and 'name' by cartridges. Address '/api/admin/cartridges' */
    selectBrands() {
      apiBrands
        .name()
        .then((response) => {
          this.nameBrands = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    /*  Ask for brand data. Address '/api/admin/brands' */
    showAll() {
      api
        .all()
        .then((response) => {
          this.cartridges = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    /* Sets property 'brand' to the selected item from the brands and activity form */
    formEditDialog(item) {
      this.titleForm = this.$t('Cartridges.Edit_cartridge');
      this.cartridge = JSON.parse(JSON.stringify(item));
      this.dialogForm = true;
      this.selectBrands();
    },
    /* Sets property 'brand' to the selected item from the brands
    * and activity form delete
    */
    formDeleteDialog(item) {
      this.cartridge = item;
      this.dialogDelete = true;
    },
    /* Sets property 'brand' to empty and activity form */
    formNewDialog() {
      this.titleForm = this.$t('Cartridges.New_cartridge');
      this.cartridge = {
        id: "",
        name: "",
      };
      this.dialogForm = true;
    },
    /* Sends to request to the server to create a new brand. 
     * Address '/api/admin/brands/new'
     */
    addNewCartridge() {
      api
        .new(this.cartridge)
        .then((response) => {
          this.showAll();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    /* Sends to request to the server to edit current brand. 
     * Address '/api/admin/brands/$id/edit'
     */
    editCartridge() {
      api
        .edit(this.cartridge.id, this.cartridge)
        .then((response) => {
          this.showAll();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    /* Sends to request to the server to delete current brand. 
     * Address '/api/admin/brands/$id/delete'
     */
    deleteCartridge() {
      api
        .delete(this.cartridge.id)
        .then((response) => {
          this.showAll();
        })
        .catch((error) => {
          console.log;
        });
      this.dialogDelete = false;
    },
    /* Edit or create new brand on server */
    saveCartridge() {
      if (this.cartridge.id === "") {
        this.addNewCartridge();
      } else {
        this.editCartridge();
      }
      this.dialogForm = false;
    },
    /* Removes cartridge from property 'brand' by index of array  */
    deleteBrand(index) {
      this.cartridge.brands.splice(index,1);
    },
    /* Adds array of cartridge in property brand' if id does't exist in the array
    * and if array of cartridge isn't empty
    */
    addBrand() {
      const findId = this.cartridge.brands.filter(
        (element) => element.id === this.selectBrand.id
      );
      if (findId.length === 0 && this.selectBrand !== '') {
        this.cartridge.brands.push(this.selectBrand);
      }
    },
  },
  created() {
    this.showAll();
  },
};
</script>