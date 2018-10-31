const express = require('express')
const router = express.Router();
const request = require('request');
const ajax = require('ajax');
const axios = require('axios');
const merge = require('merge');
const absorb = require('absorb');
const jwt = require('jsonwebtoken');

const checkAuth = require('../middleware/check-auth');
const ProductsController = require('../controllers/products');
const MongoClient = require('mongodb').MongoClient
const url = "mongodb://localhost:27017/test"

//GET
router.get('/getall', ProductsController.products_get_all);
router.get('/:id',ProductsController.products_find_id);
router.get('/',(req , res , next) =>{
    res.status(200).json({
        message : 'Get Product /'
    });
});
router.get('/one',(req , res , next) =>{
    res.status(200).json({
        message : 'Get Product /one'
    });
});

//POST
router.post('/add', ProductsController.products_add);
router.post('/column',ProductsController.products_find_columns);
router.post('/row',ProductsController.products_find_rows);
router.post('/',(req , res , next) =>{
    const Product = {
        name: req.body.name,
        price: req.body.price
    };
    console.log(req.body);
    res.status(200).json({
        message : 'Post Product /Product',
        createdProduct: Product
    });
});

module.exports = router;