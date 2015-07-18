import Ember from 'ember';
import config from '../../../config/environment';

const {
  $,
  Component
} = Ember;

export default Component.extend({

  search: false,

  team: null,
  tournamentId: '',
  logoPath: '',

  classNames: ['ggf-card mdl-card mdl-shadow--2dp demo-card-event'],

  classNameBindings: [
    'isDirty:mdl-color--green-50'
  ],

  isDirty: Ember.computed.alias('search'),

  teams: null,

  actions: {
    queryOptions: function (query, promise) {
      const url = config.APP.host + '/' + config.APP.namespace + '/teams/search';

      $.ajax({
        url: url,
        type: 'GET',
        data: {term: query.term},
        success: (result) => {
          let teams = Ember.A([
            {
              id: "1",
              text: "Liverpool",
            }, {
              id: "2",
              text: "Chelsea",
            }
          ]);

          console.log('teams', result);

          this.teams = result.teams;

          promise.resolve(this.teams);
        }
      });
    },

    search() {
      this.set('search', true);
    },

    undo() {
      this.set('team', null);
      this.set('logoPath', '');

      this.set('search', false);
    },

    submit() {
      this.sendAction('submit', {
        team: this.get('team'),
        tournamentId: this.get('tournamentId')
      });

      this.set('team', null);
      this.set('logoPath', '');

      this.set('search', false);
    }
  }
});