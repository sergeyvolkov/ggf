import Ember from 'ember';
import  ApplicationRoutemixin from 'simple-auth/mixins/application-route-mixin';

export default Ember.Route.extend(ApplicationRoutemixin, {
  actions: {
    authenticate: function(provider) {
      this.get('session').authenticate('authenticator:torii-oauth2', {
        torii: this.get('torii'),
        provider: provider
      }, function(error) {
        alert('There was an error when trying to sign you in: ' + error);
      });
      /*
       var _this = this;
       this.get('session').authenticate('simple-auth-authenticator:torii', 'facebook-oauth2').then(function() {
       var authCode = _this.get('session.authorizationCode');
       console.log(authCode);
       });
       */
    }
  }
});
