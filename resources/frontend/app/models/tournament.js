import Ember from 'ember';
import DS from 'ember-data';

const { Model, attr, hasMany } = DS;

const { computed } = Ember;

export default Model.extend({
  name:         attr('string'),
  description:  attr('string'),
  type:         attr('string'),
  status:       attr('string'),
  membersType:  attr('string'),
  teams:        hasMany('teams', {async: false}),
  matches:      hasMany('matches', {async: false}),
  tablescore:   hasMany('tablescore', {async: false}),

  isDraft: computed('status', function () {
    return this.get('status') === 'draft';
  })
});
