function InsuranceShipping(info) {

    var data, infoNode, costNode, insuranceCheckbox;

    var init = function(info) {
        data = info;
        infoNode = jQuery('#insure-info');
        insuranceCheckbox = jQuery('#s_insurance');
        costNode = jQuery('#s_insurance_cost');
        addEvents();
    }

    var addEvents = function() {
        if (data.length) {
            jQuery('body').on('change', '.sp-methods input[name=shipping_method]' , function() {
                hideInfo();
                var value = jQuery(this).val();
                data.forEach(function(item) {
                    if (item.isEnabled && ~value.indexOf(item.method)) {
                        showInfo(item);
                    }
                })
            })
        }
    }

    var hideInfo = function() {
        infoNode.css('display', 'none');
        insuranceCheckbox.prop('checked', false);
    }

    var showInfo = function(item) {
        infoNode.css('display', 'block');
        costNode.html(item.message)
    }

    init(info);
}



