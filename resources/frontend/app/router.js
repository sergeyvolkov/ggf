import Ember from 'ember';
import config from './config/environment';

var Router = Ember.Router.extend({
  location: config.locationType
});

Router.map(function() {
  this.resource('tournaments', function() {
    this.route('new');

    this.resource('tournament', {path: '/tournament/:tournamentId'}, function() {
      this.route('tablescore');
      this.route('teams');
      this.route('team', {path: '/team/:id'});
      this.route('matches');
      this.route('settings');
    });
  });

  this.resource('leagues', function() {
    this.resource('league', {path: '/:id'}, function() {
      this.route('teams');
    });
  });
});

export default Router;
