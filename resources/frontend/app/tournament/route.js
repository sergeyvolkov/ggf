import Ember from 'ember';

export default Ember.Route.extend({
  model(params) {
    const store = this.store;

    return store.find('tournament', params.id);
  },

  setupController(controller, model) {
    controller.set('status', model.get('status'));
  }
});
