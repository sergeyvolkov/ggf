import Ember from 'ember';
import ApplicationRouteMixin from 'simple-auth/mixins/application-route-mixin';

export default Ember.Route.extend(ApplicationRouteMixin, {
  actions: {

    authenticate: function(provider) {
      this.get('session').authenticate('authenticator:torii-oauth2', {
        torii: this.get('torii'),
        provider: provider
      }).then(function() {
        //@todo Show success message

      }).catch(function(err) {
        //@todo Show error message

        console.log('[ERR]', err);
      });
    }
  }
});
