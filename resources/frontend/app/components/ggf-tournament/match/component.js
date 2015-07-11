import Ember from 'ember';

export default Ember.Component.extend({
  tagName: 'tr',

  score: function() {
    let match = this.get('match');

    const MATCH_STATUS_NOT_STARTED = 'not_started';

    if (match.get('status') === MATCH_STATUS_NOT_STARTED) {
      match.set('homeScore', '-');
      match.set('awayScore', '-');
    }

    return [match.get('homeScore'), match.get('awayScore')].join(' : ');
  }.property()
});
