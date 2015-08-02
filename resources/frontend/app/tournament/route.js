import Ember from 'ember';

export default Ember.Route.extend({
  model(params) {
    const store = this.store;

    return store.find('tournament', params.id);
  },

  setupController(controller, model, transition) {
    this._super(controller, model, transition);

    controller.set('status', model.get('status'));

    this.controllerFor('application').addObserver('currentPath', this, this.currentPathChanged);
  },

  currentPathChanged(applicationContoller) {
    let currentTournamentsRoute = applicationContoller.get('currentPath').split('.')[2];

    this.controllerFor('tournament').set('selectedTab', currentTournamentsRoute);
  }
});
