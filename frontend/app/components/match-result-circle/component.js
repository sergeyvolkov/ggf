import Ember from 'ember';

export default Ember.Component.extend({
  classNameBindings: ['circleColor'],
  attributeBindings: ['customTitle:title'],

  result: '',

  circleColor: function() {
    let result;

    switch (this.get('match.result')) {
      case 'W': // win
        result = 'win';
        break;
      case 'D': // draw
        result = 'draw';
        break;
      case 'L': // lose
        result = 'lose';
        break;
      default:
        result = 'not-started';
        break;
    }

    this.set('result', result);

    return 'match-result match-result-' + result;
  }.property('result'),

  customTitle: function() {
    let matchId = this.get('match.matchId'),
        result = this.get('result');

    return `Match #${matchId} - ${result}`;
  }.property()

});
