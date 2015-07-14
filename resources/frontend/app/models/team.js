import {Model, attr}  from 'ember-data';

export default Model.extend({
  name:         attr('string'),
  logoPath:     attr('string'),
  tournamentId: attr('number')

  //tournamentId: belongsTo('tournament')
});
