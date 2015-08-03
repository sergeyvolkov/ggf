import DS from 'ember-data';

const { Model, attr, belongsTo } = DS;

export default Model.extend({
  position:         attr('number'),
  matches:          attr('number'),
  wins:             attr('number'),
  draws:            attr('number'),
  losts:            attr('number'),
  points:           attr('number'),
  goalsScored:      attr('number'),
  goalsAgainsted:   attr('number'),
  goalsDifference:  attr('number'),
  team:             belongsTo('team', {async: false})
});
