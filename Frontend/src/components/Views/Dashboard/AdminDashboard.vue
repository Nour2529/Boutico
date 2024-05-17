<template>
    <div class="admin-dashboard" style="height:400vh;">
      <PanelMenu :model="menuItems" style="width: 20%;background-color:rgb(234, 231, 231)">
        <template #item="{ item }">
          <div class="menu-item" @click="handleItemClick(item)">
            <i :class="item.icon"></i>
            {{ item.label }}
          </div>
        </template>
      </PanelMenu>
  
      <!-- Active page content -->
      <div class="active-page" style="width: 80%;">
        <component :is="activePage" />
      </div>
    </div>
  </template>
  
  <script>
  import AddProduct from '../../AddProduct.vue';
  import AddBrand from '../../AddBrand.vue';
  import AddCategory from '../../AddCategory.vue';
  import ListProductsAdmin from '../../ListProductsAdmin.vue';
  import ListManufactAdmin from '../../ListBrandAdmin.vue';
    import ListCategoryAdmin from '../../ListCategoryAdmin.vue';
    import PanelMenu  from 'primevue/panelmenu';
    import WelcomeAdmin from './WelcomeAdmin.vue'


  
  export default {
    data() {
      return {
        activePage: 'WelcomeAdmin',
      };
    },
    methods: {
        setActivePage(page) {
            this.activePage = page;
        },
      handleItemClick(item) {
        if (item.command) {
          item.command();
        } else if (item.items) {
          // Handle dropdown items
          this.activePage = item.items[0].command;
        }
      },
    },
    computed: {
      menuItems() {
        return [
          {
            label: 'Dashboard',
            icon: 'pi pi-fw pi-home',
            command: () => this.setActivePage('WelcomeAdmin'),},
          {
            label: 'Product',
            icon: 'pi pi-fw pi-list',
            items: [
              { label: 'List Products', command: () => this.setActivePage('ListProductsAdmin') },
              { label: 'Add Product', command: () => this.setActivePage('AddProduct') },
            ],
          },
          {
            label: 'Brand',
            icon: 'pi pi-fw pi-industry',
            items: [
              { label: 'List Brands', command: () => this.setActivePage('ListManufactAdmin') },
              { label: 'Add Brand', command: () => this.setActivePage('AddBrand') },
            ],
          },
          {
            label: 'Category',
            icon: 'pi pi-fw pi-tags',
            items: [
              { label: 'List Categories', command: () => this.setActivePage('ListCategoryAdmin') },
              { label: 'Add Category', command: () => this.setActivePage('AddCategory') },
            ],
          },
        ];
      },
    },
    components: {
      AddProduct,
      AddBrand,
      AddCategory,
      ListProductsAdmin,
      ListManufactAdmin,
      ListCategoryAdmin,
      PanelMenu, // Ensure PanelMenu is registered
        WelcomeAdmin,

    },
  };


  </script>
  
  <style scoped>
  .admin-dashboard {
    display: flex;
    height: 100vh;
  }
  
  .menu-item {
    cursor: pointer;
    padding: 10px;
    box-sizing: border-box;
  }
  
  .active-page {
    padding: 20px;
    box-sizing: border-box;
  }
  </style>
  