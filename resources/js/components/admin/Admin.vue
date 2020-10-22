<template>
  
    <v-row>
        <v-col cols="10">
                <router-view>
                </router-view>
        </v-col>
        <v-col cols="2">
            <v-navigation-drawer
                mobile-breakpoint="0"
            >
            <v-list>
            <v-subheader>{{ $t('General.ACTIONS') }}</v-subheader>
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
                    <v-list-item-title v-text="$t(item.text)" ></v-list-item-title>
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
            { text: 'General.Orders', icon: 'mdi-basket', url: { 'name': 'admin.orders' } },
            { text: 'General.Printers_list', icon: 'mdi-printer-settings', url: { 'name': 'admin.printersList' } },
            { text: 'General.Printers_brand', icon: 'mdi-rename-box', url: { 'name': 'admin.printersBrand' } },
            { text: 'General.Cartridges', icon: 'mdi-artstation', url: { 'name': 'admin.cartridges' } },
        ],
    }),
}
</script>