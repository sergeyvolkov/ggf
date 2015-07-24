import Ember from 'ember';
import AuthenticatedRouteMixin from 'simple-auth/mixins/authenticated-route-mixin';

const {
  RSVP
} = Ember;

export default Ember.Route.extend(AuthenticatedRouteMixin, {

  model: function() {
    let store = this.store;
    let tournamentId = this.paramsFor('tournament').id;

    return RSVP.hash({
      tournament: store.find('tournament', tournamentId, function(tournament) {
        return !tournament.get('isDirty');
      })
    });
  },

  actions: {
    save (params) {
      const store = this.store;

      // @todo update with plain AJAX and then save record?
      return new Ember.RSVP.Promise((resolve, reject) => {
        store.find('tournament', this.paramsFor('tournament').id).then((tournament) => {

          // update `oneWay` binded attributes
          tournament.set('name', params.name);
          tournament.set('description', params.description);

          tournament.save()
            .then(() => {
              resolve();
            })
            .catch((err) => {
              tournament.rollbackAttributes();

              reject(err);
            });
        });
      });
    }
  }
});
