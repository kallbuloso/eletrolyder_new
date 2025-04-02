import { defineStore } from 'pinia'

export const useThemeStore = defineStore('themeStore', {
  state: () => ({
    _themeMode: 'dark',
    _isOpen: true // default value
  }),
  getters: {
    isOpen: (state) => state._isOpen,
    themeMode: (state) => state._themeMode
  },
  actions: {
    toggleTheme() {
      this._themeMode = this._themeMode === 'dark' ? 'light' : 'dark'
    },
    toggleDrawer() {
      this._isOpen = !this._isOpen
    }
  },
  persist: {
    enabled: true,
    strategies: [
      {
        key: 'themeStore',
        storage: localStorage
      }
    ]
  }
})
