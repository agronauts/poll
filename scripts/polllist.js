/*
 * The JavaScript for the AJAX version of the Northwind product browser.
 * This version manages all interaction using AJAX calls back
 * to the server, for which an extra controller is required.
 * It uses the basic XMLHttpRequest for AJAX rather than the higher level
 * jQuery functions so you can see what is going on.
 *
 * Richard Lobb, 20 June 2014.
 */

(function () {
    'use strict';
    var REQUEST_COMPLETE = 4,      // ReadyState of XMLHttpRequest when done
        OK = 200,                  // HTTP response OK code
        PRODUCT_DETAILS_KEYS = [   // A list of product labels and corresponding db keys
            ['Product ID',      'id'],
            ['Product Name',    'productName'],
            ['Category',        'category'],
            ['Quantity per unit', 'quantityPerUnit'],
            ['Unit price',      'unitPrice'],
            ['Units in stock',  'unitsInStock'],
            ['Units on Order',  'unitsOnOrder'],
            ['Reorder level',   'reorderLevel'],
            ['Supplier',        'supplier'],
            ['Discontinued',    'discontinued']
        ],

        productDetailsXHR = null,  // XMLHttpRequest for product details
        categoryCombo = $('select#Category'),
        productCombo = $('select#Product'),
        productDetailsTable = $('table#ProductDetails');


    // Called asynchronously as the state of the
    // productDetailsXHR for the currently select product details changes.
    function detailsArrived(productDetail) {
        var key, keyOutput, value;
        
        // Empty table
        productDetailsTable.empty();

        // Add to table
        for (var i in PRODUCT_DETAILS_KEYS) {
            keyOutput = PRODUCT_DETAILS_KEYS[i][0];
            key = PRODUCT_DETAILS_KEYS[i][1];
            value = productDetail[key];
            productDetailsTable.append("<tr> <td>" + keyOutput +
                    "</td> <td>" + value + "</td> </tr>");
        }
    }


    // Initiate a request for the details for the currently selected
    // product in the products combobox.
    function getProductDetails() {
        var prodId = productCombo.val(),
        resource = "/~pjn59/365/NorthwindBrowser_AJAX/index.php/ajax/productDetails/" + prodId;
        $.getJSON(resource, detailsArrived);
    }


    // Called asynchronously as the state of the
    // XMLHttpRequest for a new product list changes.
    function newProductListArrived(productList) {
        var productName, i, id;

        $('option', productCombo).remove();  // Delete all existing options

        for (i = 0; i < productList.length; i += 1) {
            id = productList[i].id;
            productName = productList[i].name;
            productCombo.append("<option value='" + id +
                    "'>" + productName + '</option>');
        }

        // Finally, select the first item and load the product details
        $('option:first', productCombo).attr('selected', true);
        getProductDetails();
        
    }


    // Initiate a request for a list of products in the given category
    function getProductList(categoryId) {
        var resource = "/~pjn59/365/NorthwindBrowser_AJAX/index.php/ajax/productList/" + categoryId;
        $.getJSON(resource, newProductListArrived);
        
    }


    // Ask the server for a new product list whenever the category combo changes
    categoryCombo.change(function () {
        var categoryId = $(this).val();
        getProductList(categoryId);
    });


    // Ask the server for product details whenever the product combo changes
    productCombo.change(getProductDetails);


    // Kick things off by selecting the first categoryCombo entry and
    // initialising the rest of the view accordingly.

    $('option:first', categoryCombo).attr('selected', true);
    getProductList(categoryCombo.val());

}());
