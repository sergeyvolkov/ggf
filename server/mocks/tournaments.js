module.exports = function(app) {
  var express = require('express');
  var tournamentsRouter = express.Router();

  var tournaments = [
    {
      id:           5,
      name:         'GGG International League #2',
      description:  '',
      teams:        ['Spain', 'Argentina', 'Netherlands', 'Colombia', 'Uruguay', 'Chile']
    }
  ];

  tournamentsRouter.get('/', function(req, res) {
    res.send({
      'tournaments': tournaments
    });
  });

  tournamentsRouter.post('/', function(req, res) {
    res.status(201).end();
  });

  tournamentsRouter.get('/:id', function(req, res) {
    res.send({
      'tournaments': {
        id: req.params.id
      }
    });
  });

  tournamentsRouter.put('/:id', function(req, res) {
    res.send({
      'tournaments': {
        id: req.params.id
      }
    });
  });

  tournamentsRouter.delete('/:id', function(req, res) {
    res.status(204).end();
  });

  app.use('/api/v1/tournaments', tournamentsRouter);
};
