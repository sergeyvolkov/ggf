import Ember from 'ember';
import config from './config/environment';

var Router = Ember.Router.extend({
  location: config.locationType
});

Router.map(function() {
  this.resource('tournaments', function() {
    this.resource('tournament', {path: '/tournament/:tournamentId'});
  });
});

export default Router;
