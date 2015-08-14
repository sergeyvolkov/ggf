import Ember from 'ember';
import AuthenticatedRouteMixin from 'simple-auth/mixins/authenticated-route-mixin';

const {
  RSVP
  } = Ember;

export default Ember.Route.extend(AuthenticatedRouteMixin, {

  model: function () {
    let store = this.store;
    let tournamentId = this.paramsFor('tournament').tournamentId;

    return RSVP.hash({
      tournament: store.find('tournament', tournamentId, function (tournament) {
        return !tournament.get('isDirty');
      })
    });
  },

  actions: {
    save (params) {
      const flashMessages = Ember.get(this, 'flashMessages');
      const store = this.store;

      return new Ember.RSVP.Promise((resolve, reject) => {
        store.find('tournament', this.paramsFor('tournament').tournamentId).then((tournament) => {

          // update `oneWay` binded attributes
          tournament.set('name', params.name);
          tournament.set('description', params.description);

          tournament.save()
            .then(() => {
              resolve();
              flashMessages.success('Tournament has been saved');

            })
            .catch((err) => {
              tournament.rollbackAttributes();

              flashMessages.danger('Unable to save tournament');


              reject(err);
            });
        });
      });
    }
  }
});
