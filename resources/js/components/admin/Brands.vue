<template>
  <div>
    <!-- Button for modal form 'dialogForm' -->
    <v-row>
      <v-col>
        <v-btn color="primary" @click="formNewDialog()">New Brand</v-btn>
      </v-col>
    </v-row>
    <!-- Table brands -->
    <v-data-table
      :headers="headers"
      :items="brands"
      :items-per-page="25"
      :sort-by="'name'"
      class="elevation-1"
    >
      <!-- Column 'cartridge' -->
      <template v-slot:item.cartridges="{ item }">
        <p class="px-3 pt-3" v-if="item.cartridges.length === 0">No data on cartridges</p>
        <ul class="py-3" v-if="item.cartridges.length !== 0">
          <li v-for="cartridge in item.cartridges" :key="cartridge.id">{{ cartridge.name }}</li>
        </ul>
      </template>
      <!-- Column action with action icons -->
      <template v-slot:item.actions="{ item }">
        <v-icon v-text="'mdi-pencil'" color="green" @click="formEditDialog(item)"></v-icon>
        <v-icon v-text="'mdi-delete-forever'" color="red" @click="formDeleteDialog(item)"></v-icon>
      </template>
    </v-data-table>
    <!-- Modal form for delete selected brand -->
    <v-dialog v-model="dialogDelete" max-width="290">
      <v-card>
        <v-card-title class="headline">Delete brand</v-card-title>

        <v-card-text>Are you sure that you want to delete this brand?</v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn color="error" @click="deleteBrand()">Delete</v-btn>

          <v-btn color="cancel" text @click="dialogDelete = false">Cancel</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <!-- Modal form for new brand and edit brand with cartridges -->
    <v-dialog v-model="dialogForm" max-width="600">
      <v-card>
        <v-card-title>
          <span class="headline" v-text="titleForm"></span>
        </v-card-title>

        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field v-model="brand.name" label="Brands name" required></v-text-field>
              </v-col>
            </v-row>
            <!-- View cartridges for selected brand if it's not new brand -->
            <div v-if="brand.id !== ''">
              <v-row>
                <v-col cols="10">
                  <v-divider class="mx-3"></v-divider>
                  <v-select
                    v-model="selectCartridge"
                    :items="nameCartridges"
                    label="Select cartridge"
                    id="id"
                    item-text="name"
                    return-object="true"
                  ></v-select>
                </v-col>
                <v-col cols="2">
                  <v-btn icon @click="addCartridge()" class="ml-4 mt-3">
                    <v-icon color="green">mdi-plus-circle</v-icon>
                  </v-btn>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12">
                  <v-list-item-group color="primary">
                    <v-list-item v-for="cartridge in brand.cartridges" :key="cartridge.id" @click>
                      <v-list-item-content>
                        <v-list-item-title v-text="cartridge.name"></v-list-item-title>
                      </v-list-item-content>

                      <v-list-item-action>
                        <v-btn icon @click="deleteCartridge()">
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

          <v-btn color="success" @click="saveBrand()">Save</v-btn>

          <v-btn color="cancel" text @click="dialogForm = false">Cancel</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
import api from "../../api/brands";
import apiCartridges from "../../api/cartridges";
export default {
  data() {
    return {
      headers: [
        {
          text: "id",
          align: "start",
          value: "id",
        },
        { text: "Name", value: "name" },
        { text: "Cartidges", value: "cartridges", sortable: false },
        { text: "Actions", value: "actions", sortable: false },
      ],
      brands: [],
      titleForm: "New brand",
      nameCartridges: [],
      selectCartridge: '',
      brand: {
        id: "",
        name: "",
        cartridges: [],
      },
      dialogDelete: false,
      dialogForm: false,
    };
  },
  methods: {
    /* Recieve 'id' and 'name' by cartridges. Address '/api//admin/brands/name' */
    selectCartridges() {
      apiCartridges
        .name()
        .then((response) => {
          this.nameCartridges = response.data.data;
          console.log(this.nameCartridges);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    showAll() {
      api
        .all()
        .then((response) => {
          this.brands = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    formEditDialog(item) {
      this.titleForm = "Edit this brand";
      this.brand = JSON.parse(JSON.stringify(item));
      this.dialogForm = true;
      this.selectCartridges();
    },
    formDeleteDialog(item) {
      this.brand = item;
      this.dialogDelete = true;
    },
    formNewDialog() {
      this.titleForm = "New brand";
      this.brand = {
        id: "",
        name: "",
      };
      this.dialogForm = true;
    },
    addNewBrand() {
      api
        .new(this.brand)
        .then((response) => {
          this.showAll();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    editBrand() {
      api
        .edit(this.brand.id, this.brand)
        .then((response) => {
          this.showAll();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    deleteBrand() {
      api
        .delete(this.brand.id)
        .then((response) => {
          this.showAll();
        })
        .catch((error) => {
          console.log;
        });
      this.dialogDelete = false;
    },
    saveBrand() {
      if (this.brand.id === "") {
        this.addNewBrand();
      } else {
        this.editBrand();
      }
      this.dialogForm = false;
    },
    deleteCartridge() {
      console.log(111);
    },
    addCartridge() {
      const findId = this.brand.cartridges.filter(
        (element) => element.id === this.selectCartridge.id
      );
      if (findId.length === 0 && this.selectCartridge !== '') {
        this.brand.cartridges.push(this.selectCartridge);
      }
    },
  },
  created() {
    this.showAll();
    api
      .brands()
      .then((response) => {
        this.brands = response.data.data.sort();
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
</script>