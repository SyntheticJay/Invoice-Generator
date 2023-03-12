import './bootstrap';

// JQuery
import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

// Datepicker
import datepicker from 'js-datepicker';
window.datepicker = datepicker;

// Toastr
import toastr from 'toastr';
window.toastr = toastr;

$(() => {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const numberFactory = (decimals = 2) => {
        return new Intl.NumberFormat('en-GB', {
            style: 'decimal',
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals
        });
    };

    window.number_format = (number, decimals = 2) => {
        return numberFactory(decimals).format(number);
    };
}); 