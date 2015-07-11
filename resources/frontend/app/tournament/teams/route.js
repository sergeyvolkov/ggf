import Ember from 'ember';

import ApplicationRouteMixin from 'simple-auth/mixins/application-route-mixin';

export default Ember.Route.extend(ApplicationRouteMixin, {
  model(params) {
    this.store.unloadAll('team');

    return this.store.filter('team', {tournamentId: this.paramsFor('tournament').tournamentId}, function (tournament) {
      return !tournament.get('isNew');
    });
  },

  actions: {
    addTeam(team) {
      const store = this.store;

      let teamRecord = store.createRecord('team', {
        name: team.name,
        tournamentId: this.paramsFor('tournament').tournamentId
      });

      teamRecord.save()
        .catch((err) => {
          //console.log('err', err);
        })
        .finally(() => {
          //console.log('finally saved');
        });
    }
  }
});
