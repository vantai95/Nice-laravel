
/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');

import _ from 'lodash';

window.app = angular.module('adminApp', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

import I18nJs from '../../common/js/I18nJs';
window.I18nJs = I18nJs;
window.translator = new I18nJs();