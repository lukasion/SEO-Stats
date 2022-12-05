import { createStore } from 'vuex'

// Create a new store instance.
const store = createStore({
  state () {
    return {
        authenticated: false,
        user: null,
        error: ''
    }
  },
  mutations: {
    SET_AUTHENTICATED (state, value) {
        state.authenticated = value;
    },

    SET_USER (state, value) {
        state.user = value;
    },

    SET_ERROR (state, value) {
        state.error = value;
    }
  },
  getters: {
    authenticated (state) {
        return state.authenticated;
    },

    user (state) {
        return state.user;
    },

    error (state) {
        return state.error;
    },
  },
  actions: {
    me ({ commit }) {
        return axios.get('/api/user', {
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json'
            }
        }).then((response) => {
            if (response.data.member_id) {
                commit('SET_AUTHENTICATED', true);
                commit('SET_USER', response.data);
            } else {
                commit('SET_AUTHENTICATED', false);
                commit('SET_USER', null);
            }
        }).catch(() => {
            commit('SET_AUTHENTICATED', false);
            commit('SET_USER', null);
        });
    },

    logout ({ commit }) {
        localStorage.removeItem('token');

        axios.post('/logout', {
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json'
            }
        });

        commit('SET_AUTHENTICATED', false);
        commit('SET_USER', null);
    },

    error({commit}, string) {
        commit('SET_ERROR', string);
    }
  }
})

export default store
