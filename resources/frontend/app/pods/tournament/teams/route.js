import Ember from 'ember';
import ApplicationRouteMixin from 'simple-auth/mixins/application-route-mixin';

const {
  Route
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
      const flashMessages = Ember.get(this, 'flashMessages');
      const tournament = this.modelFor('tournament');

      // we need to send attribute with name `tournamentId` instead of `tournament`
      team.tournamentId = tournament.get('id');

      let teamRecord = tournament.get('teams').createRecord(team);

      teamRecord
        .save()
        .catch(() => {
            flashMessages.success('Unable to add team to the tournament');

            teamRecord.rollback();
        })
        .finally(() => {
            flashMessages.success(`${teamRecord.get('name')} has been added to the tournament`);
          });
    },

    removeTeam(team) {
      const flashMessages = Ember.get(this, 'flashMessages');

      return team.destroyRecord().then(() => {
        flashMessages.success(`${team.get('name')} has been removed from the tournament`);
      }).catch(() => {
        team.rollback();

        flashMessages.danger('Unable to remove team from the tournament');
      });
    }
  }
});
