module.exports = function(app) {
  var express = require('express');
  var tournamentsRouter = express.Router();

  tournamentsRouter.get('/', function(req, res) {
    res.send({
      'tournaments': []
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
