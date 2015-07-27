import Ember from 'ember';
import ApplicationRouteMixin from 'simple-auth/mixins/application-route-mixin';

const {
  Route,
  RSVP
} = Ember;

export default Route.extend(ApplicationRouteMixin, {
  model() {
    let tournament = this.modelFor('tournament');

    return this.store.query('team', {tournamentId: tournament.get('id')})
      .then((teams) => {
        tournament.set('teams', teams);

        return tournament;
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
