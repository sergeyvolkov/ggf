import Ember from 'ember';
import DS from 'ember-data';

const {
  Model,
  attr
} = DS;


const {
  computed
} = Ember;

export default Model.extend({
  name:         attr('string'),
  description:  attr('string'),
  type:         attr('string'),
  status:       attr('string'),
  membersType:  attr('string'),
  teams:        DS.hasMany('teams', {async: false}),
  matches:      DS.hasMany('matches', {async: false}),

  isDraft: computed('status', function () {
    return this.get('status') === 'draft';
  })
});
