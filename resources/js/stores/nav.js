import { defineStore } from 'pinia';

export const useNavStore = defineStore('nav', {
  state: () => ({
    openMenus: [],       // Guarda IDs de menús abiertos
    activeRoute: null    // Ruta actual activa
  }),
  actions: {
    toggleMenu(menuId) {
      const index = this.openMenus.indexOf(menuId);
      if (index === -1) {
        this.openMenus.push(menuId);
      } else {
        this.openMenus.splice(index, 1);
      }
    },
    setActiveRoute(routeName) {
      this.activeRoute = routeName;
    }
  },
  persist: true // Opcional: Hace que el estado sobreviva a recargas
});
