import Ember from 'ember';
import ApplicationRouteMixin from 'simple-auth/mixins/application-route-mixin';

const {
  Route,
  RSVP
} = Ember;

export default Route.extend(ApplicationRouteMixin, {
  model() {

    let store = this.store;
    let tournamentId = this.paramsFor('tournament').id;

    return RSVP.hash({
      tournament: this.modelFor('tournament'),
      teams: store.query('team', {tournamentId: tournamentId}),
    }).then((hash) => {

      hash.tournament.set('teams', hash.teams);

      return hash;
    });
  },

  actions: {

    addTeam(team) {
      const tournament = this.modelFor('tournament');

      team.tournamentId = tournament.get('id');

      let teamRecord = tournament.get('teams').createRecord(team);

      teamRecord
        .save()
        .catch((err) => {
          // @todo Show error message
          console.log('[ERR]', err);

          teamRecord.rollback();
        })
        .finally(() => {
          // @todo Show success message
        });
    }
  }
});
