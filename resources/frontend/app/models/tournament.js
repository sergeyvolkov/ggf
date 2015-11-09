import Ember from 'ember';
import DS from 'ember-data';

const { Model, attr, hasMany, belongsTo } = DS;

const { computed } = Ember;

export default Model.extend({
  name:         attr('string'),
  description:  attr('string'),
  type:         attr('string'),
  status:       attr('string'),
  membersType:  attr('string'),
  teams:        hasMany('teams', {async: false}),
  matches:      hasMany('matches', {async: false}),
  tablescore:   hasMany('tablescores', {async: false}),
  standing:     hasMany('standings', {async: false}),

  isDraft: computed('status', function () {
    return this.get('status') === 'draft';
  }),

  title: computed('name', 'type', function() {
    let name = this.get('name');
    let type;

    switch (this.get('type')) {
      case 'knock_out':
        type = 'K';
        break;
      case 'league':
      default:
        type = 'L';
        break;
    }

    return `${name} (${type})`;
  })
});
