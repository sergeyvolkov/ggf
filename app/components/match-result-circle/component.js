import Ember from 'ember';

export default Ember.Component.extend({
  classNameBindings: ['circleColor'],

  circleColor: function() {
    let result;

    switch (this.get('result')) {
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

    return 'match-result match-result-' + result;
  }.property('result'),

});
