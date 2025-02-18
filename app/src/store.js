
import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    currentUser: null,
    accessToken: null
  },
  mutations: {
    setCurrentUser(state, user) {
      state.currentUser = user;
    },
    setAccessToken(state, token) {
      state.accessToken = token;
    }
  },
  actions: {
    login({ commit }, { user, token }) {
      commit('setCurrentUser', user);
      commit('setAccessToken', token);
    },
    logout({ commit }) {
      commit('setCurrentUser', null);
      commit('setAccessToken', null);
    }
  },
  getters: {
    currentUser(state) {
      return state.currentUser;
    },
    accessToken(state) {
      return state.accessToken;
    },
    isAuthenticated(state) {
      return !!state.accessToken;
    }
  }
});