<template>
  <div>
    <v-row>
      <v-col>
        <v-btn color="primary" @click="formNewDialog()">New Brand</v-btn>
      </v-col>
    </v-row>
    <v-data-table
      :headers="headers"
      :items="brands"
      :items-per-page="25"
      :sort-by="'name'"
      class="elevation-1"
    >
      <template v-slot:item.cartridges="{ item }">
        <p class="px-3 pt-3" v-if="item.cartridge.length === 0">No data on cartridges</p>
        <ul class="py-3" v-if="item.cartridge.length !== 0"> 
          <li v-for="cartridge in item.cartridge">
          {{ cartridge.name }}
          </li>
        </ul>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon v-text="'mdi-pencil'" color="green" @click="formEditDialog(item)"></v-icon>
        <v-icon v-text="'mdi-delete-forever'" color="red" @click="formDeleteDialog(item)"></v-icon>
      </template>
    </v-data-table>
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
        { text: "Actions", value: "actions" },
      ],
      brands: [],
      titleForm: "New brand",
      brand: {
        id: "",
        name: "",
      },
      dialogDelete: false,
      dialogForm: false,
    };
  },
  methods: {
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
      this.brand = item;
      this.dialogForm = true;
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