import Ember from 'ember';

export default Ember.Component.extend({
  tagName:    'table',
  classNames: ['bordered', 'centered', 'striped', 'matches-list'],

  sortedMatches: Ember.computed.sort('matches', (a, b) => {
    return a.get('id') - b.get('id');
  })

});
