import Ember from 'ember';
import ApplicationRouteMixin from 'simple-auth/mixins/application-route-mixin';

const {
  Route,
  RSVP
} = Ember;

export default Route.extend(ApplicationRouteMixin, {
  model() {
    return RSVP.hash({
      league: this.modelFor('league'),
      teams: this.store.query('league-team', {leagueId: this.paramsFor('league').id})
    });
  }
});
