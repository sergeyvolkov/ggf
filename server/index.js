// To use it create some files under `mocks/`
// e.g. `server/mocks/ember-hamsters.js`
//
// module.exports = function(app) {
//   app.get('/ember-hamsters', function(req, res) {
//     res.send('hello');
//   });
// };

module.exports = function(app) {
  var morgan    = require('morgan'),
      mongoose  = require('mongoose'),
      Tournament  = require('./models/tournament'),
      Match       = require('./models/match');

  app.use(morgan('dev'));

  mongoose.connect('mongodb://<user>:<password>@<host>:<port>/<host>');

  app.get('/api/v1/tournaments', function(req, res) {
    Tournament.find(
      {},
      {'_id': false},
      function (error, tournaments) {
        if (error) {
          res.json(error);
        }
        res.json({tournaments: tournaments});
      });
  });

  app.get('/api/v1/matches', function(req, res) {
    Match.find(
      {tournamentId: req.query.tournamentId},
      {'_id': false},
      function (error, matches) {
        if (error) {
          res.json(error);
        }
        res.json({matches: matches});
      });
  });

};
