import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('ggf-tournament/standings/pair', 'Integration | Component | ggf tournament/standings/pair', {
  integration: true
});

test('it renders', function(assert) {
  assert.expect(2);

  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{ggf-tournament/standings/pair}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#ggf-tournament/standings/pair}}
      template block text
    {{/ggf-tournament/standings/pair}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
