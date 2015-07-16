import Ember from 'ember';
import config from './config/environment';

var Router = Ember.Router.extend({
  location: config.locationType
});

Router.map(function() {
  //this.resource('index', {path: '/'});

  this.resource('tournaments', function() {
    this.resource('tournament', {path: '/tournament/:tournamentId'}, function() {
      this.route('tablescore');
      this.route('teams');
      this.route('matches');
      this.route('fixtures');
      this.route('settings');
    });
  });

  this.resource('leagues', function() {
    this.route('add');
    this.route('view', {path: '/:leagueId'});
  });
});

export default Router;
