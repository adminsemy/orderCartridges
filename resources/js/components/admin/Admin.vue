<template>
  
    <v-row>
        <v-col cols="10">
                <router-view></router-view>
        </v-col>
        <v-col cols="2">
            <v-navigation-drawer
                mobile-break-point="0"
            >
            <v-list>
            <v-subheader>ACTIONS</v-subheader>
            <v-list-item-group v-model="item" color="primary">
                <v-list-item
                v-for="(item, i) in items"
                :key="i"
                :to="item.url"
                >
                <v-list-item-icon>
                    <v-icon v-text="item.icon"></v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title v-text="item.text" ></v-list-item-title>
                </v-list-item-content>
                </v-list-item>
            </v-list-item-group>
            </v-list>
            </v-navigation-drawer>
        </v-col>
    </v-row>

</template>
<script>
export default {
    data: () => ({
        item: 0,
        items: [
            { text: 'Orders', icon: 'mdi-basket', url: { 'name': 'admin.orders' } },
            { text: 'Audience', icon: 'mdi-account', url: '' },
            { text: 'Conversions', icon: 'mdi-flag', url: '' },
        ],
    }),
}
</script>