import Ember from 'ember';

const { Component, computed } = Ember;

export default Component.extend({

  round: null,

  title: computed('round', function() {
    const teamsAmount = this.get('round').get('tournament').get('teams').get('length');
    const round = this.get('round').get('round');
    const gameType = this.get('round').get('gameType');

    switch (gameType) {
      case 'qualify':

        // @todo deduct group stage rounds for multistage tournament
        return '1/' + (parseInt(teamsAmount / 2 / round, 10));

        break;
      case 'final':
        return 'Final';
        break;
    }
  })

});
