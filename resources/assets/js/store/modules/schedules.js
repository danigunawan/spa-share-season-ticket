import axios from 'axios'
import * as types from '../mutation-types'

// state
export const schedules = {
  schedules: []
}

// getters
export const getters = {
  schedules: state => state.schedules
}

// mutations
export const mutations = {
  [types.FETCH_SCHEDULES_SUCCESS] (state, { schedules }) {
    state.schedules = schedules
  },

  [types.FETCH_SCHEDULES_FAIL] (state) {
    state.schedules = []
  }
}

// actions
export const actions = {
  async fetchSchedules ({ commit }) {
    try {
      const { data } = await axios.get('/api/schedules')

      commit(types.FETCH_SCHEDULES_SUCCESS, { schedules: data })
    } catch (e) {
      commit(types.FETCH_SCHEDULES_FAIL)
    }
  },
}
