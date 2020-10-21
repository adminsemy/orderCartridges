<template>
    <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      temporary
      app
    >
      <v-list dense>
        <v-list-item 
          v-for="link of links"
          :key="link.title"
          :to="link.url"
        >
          <v-list-item-action>
            <v-icon>{{ link.icon }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>{{ link.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar
      app
      color="warning"
      dark
    >
      <v-app-bar-nav-icon class="hidden-md-and-up" @click.stop="drawer = !drawer" />
      <v-toolbar-items class="hidden-sm-and-down">
        <v-btn
          v-for="link of links"
          :key="link.title"
          :to="link.url"
          :exact="link.exact"
          text
        >
          <v-icon left>{{ link.icon }}</v-icon>
          {{ $t(link.title) }}
        </v-btn>
      </v-toolbar-items>
    </v-app-bar>

    <v-main>
      <router-view></router-view>
    </v-main>
    <v-footer
      color="warning"
      app
    >
      <span class="white--text">&copy; 2020</span>
    </v-footer>
  </v-app>
</template>

<script>
export default {
    data: () => ({
      drawer: null,
      links: [
        {title: 'Home', icon: 'mdi-home', url: {name: 'general'}, exact: true},
        {title: 'Printers', icon: 'mdi-printer', url: {name: 'printers'}, exact: false},
        {title: 'Admin', icon: 'mdi-account-star', url: {name: 'admin'}, exact: false},
        {title: 'Login', icon: 'mdi-login', url: {name: 'home'}, exact: true},
        {title: 'User', icon: 'mdi-account', url: {name: 'users.index'}, exact: true},
      ]
    })
}
</script>