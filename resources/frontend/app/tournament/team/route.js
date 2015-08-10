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

  model: function (params) {
    const store = this.store;
    const teamId = params['id'];

    return RSVP.hash({
      team: store.find('team', teamId),
      tournament: this.modelFor('tournament'),
      teamMembers: store.query('team-member', {teamId: teamId})
    }).then((hash) => {

      let max = 0;
      let length = hash.teamMembers.get('length');

      switch (hash.tournament.get('membersType')) {
        case 'single':
          max = 1;
          break;
        case 'double':
          max = 2;
          break;
      }

      hash.team.set('teamMembers', hash.teamMembers);

      for (let i = length; i < max; i++) {
        hash.team.get('teamMembers').pushObject(
          store.createRecord('team-member', {
            'name': null,
            'teamId': null
          })
        );
      }

      return hash.team;
    });
  }
});
