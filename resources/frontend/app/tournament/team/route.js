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

    return RSVP.hash({
      team: store.find('team', teamId),
      tournament: this.modelFor('tournament'),
      teamMembers: store.query('team-member', {teamId: teamId})
    }).then((hash) => {

      hash.team.set('teamMembers', hash.teamMembers);

      return hash.team;
    });
  }
});
