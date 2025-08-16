// resources/js/stores/menuStore.js
import { defineStore } from "pinia";

export const useMenuStore = defineStore("menu", {
    state: () => ({
        openMenus: Object.fromEntries(
            [
                "personal_interno",
                "usuarios",
                "lecturadores",
                "zona",
                "zona_ruta",
                "predios",
                "instalaciones",
                "asignaciones",
                "configuracion",
            ].map((menu) => [menu, false])
        ),
    }),
    actions: {
        toggleMenu(menuId) {
            if (this.openMenus.hasOwnProperty(menuId)) {
                this.openMenus[menuId] = !this.openMenus[menuId];
            }
        },
    },
    persist: {
        enabled: true,
        strategies: [
            {
                key: "menuState",
                storage: localStorage,
            },
        ],
    },
});
