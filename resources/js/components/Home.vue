<template>
    <v-container fluid fill-height>
        <v-layout align-center justify-center >
            <v-flex xs12 md6>
                <v-card class="elevation-12">
                    <v-card-text>
                        <v-form
                        ref="form"
                        v-model="valid"
                        :lazy-validation="lazy"
                        >
                            <v-text-field
                                v-model="email"
                                :rules="emailRules"
                                label="E-mail"
                                required
                                type="email"
                            ></v-text-field>

                            <v-text-field
                                v-model="name"
                                :counter="10"
                                :rules="nameRules"
                                label="Name"
                                required
                            ></v-text-field>

                            <v-select
                                :items="items"
                                :rules="[v => !!v || 'Item is required']"
                                label="Item"
                                required
                            ></v-select>

                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    :disabled="!valid"
                                    color="success"
                                    class="mr-4"
                                    @click="onSubmit"
                                >
                                    Validate
                                </v-btn>
                            </v-card-actions>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-flex>            
        </v-layout>
    </v-container>
</template>
<script>
export default {
   data: () => ({
      valid: true,
      name: '',
      nameRules: [
        v => !!v || 'Name is required',
        v => (v && v.length <= 10) || 'Name must be less than 10 characters',
      ],
      email: '',
      emailRules: [
        v => !!v || 'E-mail is required',
        v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
      ],
      select: null,
      items: [
        'Item 1',
        'Item 2',
        'Item 3',
        'Item 4',
      ],
      lazy: true,
    }),

    methods: {
      onSubmit () {
        if (this.$refs.form.validate()) {
            const user = {
                email: this.email,
                name: this.name,
                item: this.item
            }
            console.log(user)
        }
      }
    },
}
</script>