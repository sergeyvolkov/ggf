import Ember from 'ember';

import ApplicationRouteMixin from 'simple-auth/mixins/application-route-mixin';

export default Ember.Route.extend(ApplicationRouteMixin, {
  model() {
    const store = this.store;
    const tournamentId = this.paramsFor('tournament').id;

    this.store.unloadAll('team');

    return Ember.RSVP.hash({
      tournamentId: tournamentId,
      teams: store.filter('team', {tournamentId: tournamentId}, function (tournament) {
        return !tournament.get('isNew');
      })
    });
  },

  actions: {

    addTeam(team) {

      const store = this.store;

      let teamRecord = store.createRecord('team', {
        teamId: team.team.id,
        tournamentId: this.paramsFor('tournament').id
      });

      teamRecord.save()
        .catch((err) => {
          // @todo Show error message
          console.log('[ERR]', err);
        })
        .finally(() => {

          return new Ember.RSVP.Promise(function (resolve, reject) {
            this.store.find('tournament', teamRecord.get('tournamentId')).then(function (tournament) {
              this.store.unloadRecord(tournament);

              this.store.find('tournament', teamRecord.get('tournamentId'))
                .then(function (tournament) {
                  resolve(tournament);
                }.bind(this))
                .catch(function(err) {
                  reject(err);
                });

            }.bind(this));
          }.bind(this));
        });
    }
  }
});
