import Ember from 'ember';

export default Ember.Route.extend({
  model(params) {
    const store = this.store;

    return store.find('tournament', params.tournamentId);
  },

  setupController(controller, model, transition) {
    this._super(controller, model, transition);

    controller.set('status', model.get('status'));

    this.controllerFor('application').addObserver('currentPath', this, this.currentPathChanged);
  },

  currentPathChanged(applicationContoller) {
    let currentTournamentsRoute = applicationContoller.get('currentPath').split('.')[2];

    // teams and team routes must have one tab
    if (currentTournamentsRoute === 'team') {
      currentTournamentsRoute = 'teams';
    }

    let tabList = ['tablescore', 'matches', 'teams', 'settings'];

    if (0 <= tabList.indexOf(currentTournamentsRoute)) {
      this.controllerFor('tournament').set('selectedTab', currentTournamentsRoute);
    }
  }
});
