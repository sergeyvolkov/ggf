import Ember from 'ember';

export default Ember.Component.extend({
  teamsList: function() {
    let teams = this.get('tournament.teams');

    if (Ember.isArray(teams)) {
      return teams.sort().join(', ');
    }

    return false;
  }.property()
});
