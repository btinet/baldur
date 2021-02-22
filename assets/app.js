// assets/app.js
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';
import 'tablesorter/dist/js/jquery.tablesorter.min';
import 'tablesorter/dist/js/jquery.tablesorter.widgets.min';

// loads the Icon plugin
UIkit.use(Icons);



$(document).ready(function() {

    $(".ts-index").tablesorter({
        theme : "default",
        widthFixed: true,
        // widget code contained in the jquery.tablesorter.widgets.js file
        // use the zebra stripe widget if you plan on hiding any rows (filter widget)
        // the uitheme widget is NOT REQUIRED!
        widgets : [ "filter", "columns", "zebra", "saveSort" ],
        widgetOptions : {
            columns: ["primary", "secondary", "tertiary"],
            filter_reset: ".reset",
            filter_childRows   : false,
            filter_hideFilters : false,
            filter_ignoreCase  : true,
            filter_cssFilter:
                [
                    'uk-input uk-form-small',
                    'uk-input uk-form-small',
                    'uk-select uk-form-small',
                    'uk-input uk-form-small',
                    'uk-input uk-form-small',
                    'uk-input uk-form-small'
                ],
            filter_functions: {

                // Add select menu to this column
                // set the column value to true, and/or add "filter-select" class name to header
                '.ts-title' : true,
                'ts-action': false,
            }
        }
    })

    $(".ts-view").tablesorter({
        theme : "default",
        widthFixed: true,
        // widget code contained in the jquery.tablesorter.widgets.js file
        // use the zebra stripe widget if you plan on hiding any rows (filter widget)
        // the uitheme widget is NOT REQUIRED!
        widgets : [ "filter", "columns", "zebra", "saveSort" ],
        widgetOptions : {
            columns: ["primary", "secondary", "tertiary"],
            filter_reset: ".reset",
            filter_childRows   : false,
            filter_hideFilters : false,
            filter_ignoreCase  : true,
            filter_cssFilter:
                [
                    'uk-input uk-form-small',
                    'uk-input uk-form-small',
                    'uk-input uk-form-small',
                    'uk-input uk-form-small',
                    'uk-input uk-form-small'
                ],
            filter_functions: {

                // Add select menu to this column
                // set the column value to true, and/or add "filter-select" class name to header
                '.ts-title' : true,
                'ts-action': false,
            }
        }
    })

    $('.table-reset').click(function() {
        $('table').trigger('sortReset');
        return false;
    });

});