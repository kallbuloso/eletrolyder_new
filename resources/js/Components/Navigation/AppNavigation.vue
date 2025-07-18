<template>
  <div class="navigation">
    <!-- Navigation Icon Menu -->
    <div class="navigation-icon-menu">
      <ul>
        <li v-for="(item, index) in menuItems" :key="index" v-tooltip="item.tooltip" :class="{ active: activeMenu === item.target }">
          <a :href="item.target" class="no-underline" @click.prevent="navigate(item.target)">
            <v-badge v-if="item.badge" color="error" :content="item.badge" dot>
              <template v-if="item.img">
                <img :src="item.img" alt="icon" style="width: 24px; height: 24px" />
              </template>
              <template v-else>
                <v-icon :icon="item.icon" />
              </template>
            </v-badge>
            <template v-else>
              <template v-if="item.img">
                <img :src="item.img" alt="icon" style="width: 24px; height: 24px" />
              </template>
              <template v-else>
                <v-icon>
                  {{ item.icon }}
                </v-icon>
              </template>
            </template>
          </a>
        </li>
      </ul>
      <ul>
        <li v-tooltip="'Alertas'">
          <a href="#" class="go-to-page">
            <v-icon icon="mdi-bell-outline" />
          </a>
        </li>
        <li v-tooltip="'Sair'">
          <a class="go-to-page">
            <Link :href="route('logout')" method="post">
              <v-icon icon="iconify:ic:round-logout" />
            </Link>
          </a>
        </li>
      </ul>
    </div>

    <!-- Navigation Menu Body -->
    <div class="navigation-menu-body">
      <ul
        v-for="(section, index) in menuSections"
        v-show="activeMenu === '#' + section.id"
        :id="section.id"
        :key="index"
        :class="{ 'navigation-active': activeMenu === '#' + section.id || isActiveSection(activeMenu) }"
      >
        <li class="navigation-divider">{{ section.title }}</li>
        <NavigationMenu :items="section.items" />
      </ul>
    </div>
  </div>
</template>

<script setup>
import mercadoLivreIcon from '@images/svg/mercado-livre.svg'
const activeRoute = ref(null)
// Reactive data
const activeMenu = ref(activeRoute.value)

const navigate = (target) => {
  activeMenu.value = target
}

// O target deve ser o id do menu com o mesmo nome do grupo da rota
const menuItems = [
  { tooltip: 'Dashboard', target: '#dashboard', icon: 'iconify:fluent-mdl2:b-i-dashboard', badge: 5 },
  { tooltip: 'Ordem de Serviço', target: '#orders', icon: 'iconify:game-icons:auto-repair' },
  { tooltip: 'Chats', target: '#chats', icon: 'iconify:gridicons:chat' },
  { tooltip: 'Mercado Livre', target: '#meli', img: mercadoLivreIcon },
  { tooltip: 'Cadastros', target: '#registers', icon: 'iconify:material-symbols:app-registration-outline-sharp' },
  { tooltip: 'Configurações', target: '#settings', icon: 'iconify:carbon:settings-edit' }
]

const menuSections = ref([
  // Dashboard Section
  {
    id: 'dashboard',
    title: 'Dashboard',
    items: [
      {
        title: 'Dashboard',
        icon: 'mdi-view-dashboard',
        href: 'dashboard'
      }
    ]
  },
  // Registers Section
  {
    id: 'registers',
    title: 'Cadastros',
    items: [
      {
        title: 'Usuários',
        icon: 'mdi-account-group',
        href: 'registers.user.index'
      },
      {
        title: 'Clientes',
        icon: 'iconify:fa6-solid:people-line',
        href: 'registers.client.index'
      },
      {
        title: 'Fornecedores',
        icon: 'iconify:material-symbols-light:add-business',
        href: 'registers.supplier.index'
      }
      //   {
      //     title: 'Produtos*',
      //     icon: 'iconify:material-symbols-light:inventory',
      //     href: 'registers.supplier.index'
      //   },
      //   {
      //     title: 'Serviços*',
      //     icon: 'iconify:material-symbols-light:inventory',
      //     href: 'registers.supplier.index'
      //   }
    ]
  },
  // Orders Section
  {
    id: 'orders',
    title: 'Ordem de Serviço',
    items: [
      {
        title: 'Ordens de Serviço',
        icon: 'iconify:game-icons:auto-repair',
        href: 'orders.serviceOrder.index'
      },
      {
        title: 'Equipamentos',
        icon: 'iconify:tabler:device-tv-old',
        href: 'orders.soDevice.index'
      },
      {
        title: 'Configurações',
        icon: 'iconify:carbon:settings-edit',
        group: 'soSettings',
        children: [
          {
            title: 'Status da OS',
            href: 'orders.soSettings.soStatus.index'
          },
          {
            title: 'Aparelhos',
            href: 'orders.soSettings.soDevicesType.index'
          }
        ]
      }
    ]
  },
  // Chats Section
  {
    id: 'chats',
    title: 'Chats',
    items: []
  },
  // Mercado Livre Section
  {
    id: 'meli',
    title: 'Mercado Livre',
    items: []
  },
  // Settings Section
  {
    id: 'settings',
    title: 'Configurações',
    items: [
      {
        title: 'Empresa',
        icon: 'mdi-office-building',
        href: 'settings.company.index'
      },
      {
        title: 'Controle de Acesso',
        icon: 'mdi-account-key',
        href: 'settings.roles.index'
      },
      {
        title: 'Example child',
        icon: 'mdi-exit-to-app',
        group: 'child',
        children: [
          {
            title: 'Child 1',
            href: 'settings.child.child1'
          },
          {
            title: 'Child 2',
            icon: 'mdi-exit-to-app',
            href: 'settings.child.child2'
          },
          {
            title: 'Child 3',
            href: 'settings.child.child3'
          }
        ]
      }
    ]
  }
])

// Função para verificar se a seção está ativa com base na rota atual
const isActiveSection = (sectionId) => {
  const currentRouteName = route().current() ? route().current().split('.')[0] : ''
  return currentRouteName === sectionId
}

onMounted(() => {
  // Define o menu ativo com base na rota inicial
  activeRoute.value = route().current() ? '#' + route().current().split('.')[0] : '#dashboard'
  activeMenu.value = activeRoute.value
})
</script>

<style lang="scss" scoped>
.link {
  color: rgb(var(--v-theme-on-primary));
  text-decoration: none;
}
.navigation {
  position: fixed;
  left: 0;
  height: calc(100vh - #{70px});
  top: 70px;
  width: 270px;
  padding-bottom: 10px;
  background: rgb(var(--v-theme-background));
  z-index: 999;

  .navigation-icon-menu {
    height: 100%;
    width: 50px;
    float: left;
    background-color: rgb(var(--v-theme-primary));
    margin-left: 10px;
    margin-bottom: 15px;
    border-radius: 4px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 5px 0;
    overflow: hidden;

    ul {
      &:first-child {
        flex: 1;
      }

      li {
        position: relative;
        list-style: none;
        // pointer-events: none;
        a {
          position: relative;
          display: block;
          align-items: center;
          justify-content: center;
          height: 60px;
          width: 100%;
          display: flex;
          transition: background-color 0.3s;
          text-decoration: none;

          &:hover a {
            background: white 0.3s;
          }
          &:focus {
            opacity: 0.5s;
          }

          .v-icon {
            position: relative;
            color: rgb(var(--v-theme-on-primary));
            font-size: 24px;
            opacity: 0.9;
          }

          .badge {
            position: absolute;
            margin-left: auto;
            text-indent: -9999px;
            width: 8px;
            height: 8px;
            top: 10px;
            right: 10px;
            border-radius: 50%;
            padding: 0;
          }
        }

        &.active {
          position: relative;

          a {
            .v-icon {
              opacity: 1;
            }

            &:before {
              content: '';
              position: absolute;
              left: 45px;
              display: block;
              background: rgb(var(--v-theme-background));
              border-radius: 5px;
              width: 30px;
              height: 30px;
              top: 15px;
              font-size: 50px;
              line-height: 0;
              transform: rotate(45deg);
            }
          }
        }
      }
    }
  }

  & > .navigation-menu-body {
    height: 100%;
    display: flex;
    flex-grow: 1;
    flex-direction: column;

    & > ul {
      padding-bottom: 10px;
      flex: 1;
      overflow: auto;
      display: none;

      &.navigation-active {
        display: block !important;
      }

      li {
        position: relative;
        margin: 0 15px;
        margin-bottom: 2px;
        list-style: none;

        &.navigation-divider {
          //   padding: 2px 0;
          text-transform: uppercase;
          font-size: 14px;
          font-weight: 700;
          //   color: black;
          letter-spacing: 0.5px;
          margin-top: 10px;

          &:first-child {
            margin-top: 0;
            padding-top: 0;
          }
        }
      }
    }
  }
  & > .navigation-menu-body ul.navigation-active {
    display: block; /* Exibe apenas a seção ativa */
  }
}
</style>
