import Base from 'simple-auth/authorizers/base';
import Ember from 'ember';

import OAuth2 from 'simple-auth-oauth2/authorizers/oauth2';

export default OAuth2.extend({
  authorize: function(jqXHR, requestOptions) {

    console.log('!!!');

    var accessToken = this.get('session.secure.access_token');

    console.log('accessToken', accessToken);
    console.log('session', this.get('session'));

    if (this.get('session.isAuthenticated') && !Ember.isEmpty(accessToken)) {
      jqXHR.setRequestHeader('Authorization', 'Bearer ' + accessToken);
    }
  }
});
