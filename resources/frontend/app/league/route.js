import Ember from 'ember';

const {
  Route
} = Ember;

export default Route.extend({
  model(params) {
    return this.store.find('league', params.id, function (league) {
      return league.get('isNew');
    });
  }
});
