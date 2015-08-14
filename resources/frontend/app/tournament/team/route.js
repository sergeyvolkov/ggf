import Ember from 'ember';


const {
  Route,
  RSVP
} = Ember;

export default Route.extend({

  deactivate() {
    this.store.peekAll('team-member').forEach((team) => {
      if (team.get('isNew')) {
        this.store.deleteRecord(team);
      }
    });
  },

  actions: {
    assignMember(member) {
      const flashMessages = Ember.get(this, 'flashMessages');

      return member.save().then(() => {
        this.currentModel.get('teamMembers').addObject(member);

        flashMessages.success(member.get('name')+' has been assigned to the team');
      }).catch(() => {
        member.rollback();

        flashMessages.danger('Unable to assign member to the team');
      });
    },

    removeMember(member) {
      const flashMessages = Ember.get(this, 'flashMessages');

      return member.destroyRecord().then(() => {
        flashMessages.success(member.get('name')+' has been removed from the team');
      }).catch(() => {
        member.rollback();

        flashMessages.danger('Unable to remove member from the team');
      });
    }
  },

  model: function (params) {
    const store = this.store;
    const teamId = params.id;
    const tournament = this.modelFor('tournament');

    return RSVP.hash({
      team: store.find('team', teamId),
      matches: store.query('match', {tournamentId: tournament.get('id'), teamId}),
      teamMembers: store.query('team-member', {teamId})
    }).then((hash) => {
      hash.team.set('teamMembers', hash.teamMembers);

      return hash;
    });
  }
});
