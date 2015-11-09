import DS from 'ember-data';

const { Model, attr, belongsTo } = DS;

export default Model.extend({
  team:             belongsTo('team', {async: false})
});
