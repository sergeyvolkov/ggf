import Ember from 'ember';
import config from '../../../config/environment';

const {
  $,
  Component,
  observer
} = Ember;

export default Component.extend({
  classNameBindings: [':collection-item', ':avatar'],

  selected: null,

  member: null,

  selectObserver: observer('selected', (component) => {
    let member = component.get('member');
    let selected = component.get('selected');
    let team = component.get('team');

    if (!selected) {
      return false;
    }

    member.setProperties({
      'memberId': selected.id,
      'teamId': team.get('id'),
      'name': selected.name
    });

    component.sendAction('assign', member);
    component.set('selected', null);
  }),

  actions: {

    clear: function() {
      this.sendAction('remove', this.get('member'));
    },

    queryOptions: function (query, promise) {
      const url = config.APP.host + '/' + config.APP.namespace + '/teamMembers/search';

      $.ajax({
        url: url,
        type: 'GET',
        data: {tournamentId: this.get('team').get('tournament').get('id')},
        success: (result) => {
          promise.resolve(result.members);
        }
      });
    },
  }
});
