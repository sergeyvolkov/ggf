import Ember from 'ember';
import ApplicationRouteMixin from 'simple-auth/mixins/application-route-mixin';

const {
  RSVP
  } = Ember;

export default Ember.Route.extend(ApplicationRouteMixin, {
  model() {
    return RSVP.hash({
      tournament: this.modelFor('tournament')
    });
  }
});
