import { defineStore } from 'pinia'
import { api } from '@/boot/axios'

export const usePageStore = defineStore('page', {
  state: () => ({
    layout: null,
    entities: {},
    projects: [],
    loading: false,
    error: null,
  }),

  getters: {
    rows: (state) => state.layout?.rows || [],
    getEntity: (state) => (id) => state.entities[id] || null,
  },

  actions: {
    async fetchPage() {
      this.loading = true
      this.error = null
      try {
        const response = await api.get('/page')
        this.layout = response.data.layout
        this.entities = response.data.entities
      } catch (error) {
        this.error = error.message || 'Failed to load page'
        console.error('Error fetching page:', error)
      } finally {
        this.loading = false
      }
    },

    async fetchProjects() {
      try {
        const response = await api.get('/projects')
        this.projects = response.data.projects
      } catch (error) {
        console.error('Error fetching projects:', error)
      }
    },
  },
})
