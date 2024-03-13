import { defineStore } from 'pinia'
import {ApiActions} from '../api/ApiActions';
export const useLoading = defineStore('loading', {
  state: () => ({
    loading: {}
  }),
  getters: {
    getLoading(state, type: ApiActions) {
      return state.loading[type];
    },

  },
  actions: {
    setLoading(type:ApiActions) {
      this.loading[type] = !this.loading[type];
    }

  },

});


