import Ember from 'ember';

export default Ember.Component.extend({
  classNameBindings: ['circleColor'],
  attributeBindings: ['customTitle:title'],

  result: '',

  circleColor: function() {
    let result, color;

    switch (this.get('match.result')) {
      case 'W': // win
        result = 'win';
        color = 'mdl-color--green-300';

        break;
      case 'D': // draw
        result = 'draw';
        color = 'mdl-color--orange-300';

        break;
      case 'L': // lose
        result = 'lose';
        color = 'mdl-color--red-300';

        break;
      default:
        result = 'not-started';
        color = 'mdl-color--grey-300';

        break;
    }

    this.set('result', result);

    return 'match-result ' + color;
  }.property('result'),

  customTitle: function() {
    let matchId = this.get('match.matchId'),
        result = this.get('result');

    return `Match #${matchId} - ${result}`;
  }.property()

});
