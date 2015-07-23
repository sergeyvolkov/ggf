import Ember from 'ember';
import config from '../../../config/environment';

const {
  $,
  Component
} = Ember;

export default Component.extend({

  search: false,

  team: null,

  classNames: ['ggf-card mdl-card mdl-shadow--2dp demo-card-event'],

  classNameBindings: [
    'isDirty:mdl-color--green-50'
  ],

  isDirty: Ember.computed.alias('search'),

  actions: {
    queryOptions: function (query, promise) {
      const url = config.APP.host + '/' + config.APP.namespace + '/teams/search';

      $.ajax({
        url: url,
        type: 'GET',
        data: {term: query.term},
        success: (result) => {
          promise.resolve(result.teams);
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
        teamId: this.get('team').id,
        name: this.get('team').text,
        logoPath: this.get('team').logoPath
      });

      this.set('team', null);
      this.set('logoPath', '');

      this.set('search', false);
    }
  }
});