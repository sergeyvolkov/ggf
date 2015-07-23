import Ember from 'ember';

export default Ember.Route.extend({

  actions: {
    addLeague(league) {
      const store = this.store;

      let leagueRecord = store.createRecord('league', {
        name: league.name,
        logoPath: league.logoPath
      });

      leagueRecord.save()
        .then(() => {
          return new Ember.RSVP.Promise(function (resolve, reject) {
            this.transitionTo('leagues');
          }.bind(this));
        })
        .catch((err) => {
          // @todo Show error message
          console.log('[ERR]', err);

          //store.unloadRecord(leagueRecord);
        });
    }
  }
});
