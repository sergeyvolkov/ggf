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

          return new Ember.RSVP.Promise(function (resolve, reject) {
            this.store.find('tournament', teamRecord.get('tournamentId')).then(function (tournament) {
              this.store.unloadRecord(tournament);

              this.store.find('tournament', teamRecord.get('tournamentId'))
                .then(function (tournament) {
                  resolve(tournament);
                }.bind(this));

            }.bind(this))
          }.bind(this)).then(function (tournament) {
            //console.log('finally saved');
          });


        });
    }
  }
});
