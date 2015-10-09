import Ember from 'ember';

const TOURNAMENT_STATUS_STARTED = 'started';
const TOURNAMENT_STATUS_DRAFT = 'draft';
const TOURNAMENT_STATUS_COMPLETED = 'completed';

export default Ember.Component.extend({

  selectedFilterTab: TOURNAMENT_STATUS_STARTED,

  tournaments: new Ember.A(),

  tournamentsList: Ember.computed('selectedFilterTab', function () {
    const tournaments = this.get('tournaments');
    const selectedTab = this.get('selectedFilterTab');

    return tournaments.filter((tournament) => {
      switch (selectedTab) {
        case TOURNAMENT_STATUS_STARTED:
        case TOURNAMENT_STATUS_DRAFT:
        case TOURNAMENT_STATUS_COMPLETED:

          return selectedTab === tournament.get('status');

          break;
        default:

          this.set('selectedFilterTab', TOURNAMENT_STATUS_STARTED);

          return selectedTab === TOURNAMENT_STATUS_STARTED;

          break;

      }
    });
  })
});
