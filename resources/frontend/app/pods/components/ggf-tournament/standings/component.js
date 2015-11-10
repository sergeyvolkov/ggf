import Ember from 'ember';

const {computed} = Ember;

export default Ember.Component.extend({

  classNameBindings: [':standings'],

  rounds: computed('standings', function() {

    const standings = this.get('standings');

    let rounds = new Ember.A();

    standings.forEach(function(pair) {

      let round = rounds.findBy('title', pair.get('round'))

      if (!round) {
        round = Ember.Object.create({
          title: pair.get('round'),
          pairs: new Ember.A()
        });

        rounds.push(round);
      }

      round.pairs.push(pair);

    });

    return rounds;

  })

});
