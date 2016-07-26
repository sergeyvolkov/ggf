import Ember from 'ember';

const {computed} = Ember;

export default Ember.Component.extend({

  classNameBindings: [':standings'],

  standings: new Ember.A(),

  rounds: computed('standings', function() {

    const standings = this.get('standings');

    let rounds = new Ember.A();

    standings.forEach(function(pair) {

      let round = rounds.findBy('round', pair.get('round'));

      if (!round) {
        round = Ember.Object.create({
          round: pair.get('round'),
          gameType: pair.get('gameType'),
          tournament: pair.get('tournament'),
          pairs: new Ember.A()
        });

        rounds.push(round);
      }

      round.pairs.push(pair);

    });

    return rounds;

  })

});
