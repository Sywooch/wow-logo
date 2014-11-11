window.Collection = function() {
    this.count = 0;
    this.collection = {};

    this.add = function(key, item) {
        if(this.collection[key] != undefined)
            return undefined;
        this.collection[key] = item;
        return ++this.count
    };

    this.remove = function(key) {
        if(this.collection[key] == undefined)
            return undefined;
        delete this.collection[key];
        return --this.count;
    };

    this.item = function(key) {
        return this.collection[key];
    };

    this.forEach = function(block) {
        for (var key in this.collection) {
            if(this.collection.hasOwnProperty(key)) {
                block(this.collection[key]);
            }
        }
    };

    this.setCollection = function(cl) {
        var count = 0;
        $.each(cl, function() {
            count++;
        });
        this.count = count;
        this.collection = cl;
    }
};



$(function(){
    $(".info-nav li").click(function(){
        var index = $(this).index();
        $(".info-nav li").removeClass("current");
        $(this).addClass("current");
        $(".info").stop(false,false).hide();
        $(".info:eq("+index+")").stop(false,false).show();
    });

    $('.prev_img li img').click(function(){
        $('.popup .wrap_img img').attr('src', $(this).attr('src'));
    });

    $('.popup .close').click(function(){
        $('.wrap_popup').fadeOut();
    });

    $('.drop_down').click(function(){
        if($(this).parent('.wrap_el').hasClass('up')) {
            $(this).parent('.wrap_el').removeClass('up').prev('.order_block').show();
            $('.wrap_payment :before');
        } else {
            $(this).parent('.wrap_el').addClass('up').prev('.order_block').hide();
        }
    });

} );

var prevDef = function(evt) {
    evt.preventDefault();
};

/*portfolio items checkboxes*/
var togglePortfolioOrderButtons = function(item) {
    if (item.checked) {
        $(item).parent().find('.wrap_btn').show();
    } else {
        $(item).parent().find('.wrap_btn').hide();
    }
};

var renderPortfolioCheckboxes = function() {
    $('.logo_item input[type=checkbox]').each(function(n, item) {
        togglePortfolioOrderButtons(item);
    });
};

/*logo variants num*/

var $logoVarQty = $('.wrap_qty input[type=text]');

var checkLogoVarQty = function(count) {
    if (!count) {
        return 1;
    }
    if (count > 99) {
        return 99;
    }
    return count;
};

var changeLogoVarQty = function(elem, n) {
    if ('undefined' === typeof n) {
        n = 0;
    }
    var count = parseInt(elem.val()) + n;
    count = checkLogoVarQty(count);
    elem.val(count);

    localStorage.setItem('logoVarQty', count);
};

var checkMoveKeyCodes = function(e) {
    return $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
        (e.keyCode == 65 && e.ctrlKey === true) ||
        (e.keyCode >= 35 && e.keyCode <= 39);
};

var getIntFromStr = function(str) {
    return parseInt(str.replace(' ', ''));
} ;

var getFormatValFromInt = function(int) {
    /*TODO make fomat*/
    return int;
};

window.resetLocalStorage = function() {
    delete localStorage.checkedPortfolioItems;
    delete localStorage.optCheckedCollection;
    delete localStorage.logoVarQty;
    delete localStorage.checkedColors;
    delete localStorage.orderForm;
};

/*==========================START ColorBlock==================================*/
var ColorBlock = function() {

    var self = this;

    if (localStorage.checkedColors) {
        this.checkedColors = new Collection();
        this.checkedColors.setCollection(JSON.parse(localStorage.checkedColors));
    } else {
        this.checkedColors = new Collection();
    }



    self.initEvents = function() {
        $(document).on('click', '.wrap_color span', function() {
            var colorCode = $(this).attr('rel');
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                self.checkedColors.remove(colorCode);
            } else {
                if ($('.wrap_color span.active').length >= 10) {
                    return;
                }
                $(this).addClass('active');
                self.checkedColors.add(colorCode, colorCode);
            }
            localStorage.setItem('checkedColors', JSON.stringify(self.checkedColors.collection));
        });

        $(".basic").spectrum({
            change: spectrumChange,
            showInput: true,
            preferredFormat: "hex",
            cancelText: 'закрыть',
            chooseText: 'Выбрать'
        });

        function spectrumChange(color) {
            if (!self.checkColorsCount()) {
                return;
            }
            var hexColor = "transparent";
            if(color) {
                hexColor = color.toHexString();
            }
            $("#docs-content").css("border-color", hexColor);
            var colorCode = hexColor.replace('#', '');
            self.addCheckColor(colorCode);
            self.checkedColors.add(colorCode, colorCode);
            localStorage.setItem('checkedColors', JSON.stringify(self.checkedColors.collection));
        }
    };

    self.initEvents();
    self.renderCheckedColors();
};

ColorBlock.prototype.renderCheckedColors = function() {
    var self = this;
    $.each(this.checkedColors.collection, function(id, color) {
        var $item = $('.wrap_color span[rel=' + color + ']');
        if ($item.length > 0) {
            $item.click();
        } else {
            self.addCheckColor(color);
        }
    });
};

ColorBlock.prototype.checkColorsCount = function() {
    return this.checkedColors.count <= 10;
};

ColorBlock.prototype.addCheckColor = function(colorCode) {
    var html = '<span class="active" rel="' + colorCode + '" style="background-color: #' + colorCode + '"></span>';
    $('.wrap_color').append(html);
};
/*========================== END ColorBlock ==================================*/


/*==========================START PortfolioBlock==================================*/
var PortfolioBlock = function() {

    var self = this;

    if (localStorage.checkedPortfolioItems) {
        this.checkedPortfolioItems = new Collection();
        this.checkedPortfolioItems.setCollection(JSON.parse(localStorage.checkedPortfolioItems));
    } else {
        this.checkedPortfolioItems = new Collection();
    }

    self.initEvents = function() {
        $(document).on('change', '.logo_item input[type=checkbox]', function() {
            self.changePortfolioItemHandler($(this));
        });
    };

    self.initEvents();
    self.renderCheckedProtfolioItems();
};

PortfolioBlock.prototype.renderCheckedProtfolioItems = function() {
    $.each(this.checkedPortfolioItems.collection, function(id, url) {
        $('input#portfolio_' + id).click();

        var $sampleItemsBlock = $('#sampleItems');
        if ($sampleItemsBlock.length != 0) {
            if ($sampleItemsBlock.find('div[rel=' + id + ']').length == 0) {
                var html = '<div class="sample" rel="' + id + '"><img src="' + url + '" alt=""/></div>';
                $sampleItemsBlock.append(html);
            }
        }
    });
};

PortfolioBlock.prototype.changePortfolioItemHandler = function($item) {
    var id = $item.parent().find('a.open_fancybox').attr('rel');
    var url = $item.parent().find('img').attr('src');

    if ($item[0].checked) {
        this.checkedPortfolioItems.add(id, url);
    } else {
        this.checkedPortfolioItems.remove(id);
    }
    localStorage.setItem('checkedPortfolioItems', JSON.stringify(this.checkedPortfolioItems.collection));
};
/*==========================END PortfolioBlock==================================*/


/*==========================START TariffBlock==================================*/
var TariffBlock = function() {

    if (localStorage.optCheckedCollection) {
        this.optCheckedCollection = new Collection();
        this.optCheckedCollection.setCollection(JSON.parse(localStorage.optCheckedCollection));
    } else {
        this.optCheckedCollection = new Collection();
    }

    if (localStorage.getItem('logoVarQty')) {
        $logoVarQty.val(localStorage.getItem('logoVarQty'));
    }

    this.mainPage = true;

    this.$tariff1PriceWas = $('.item1.tariff_item .total_price span');

    if (this.$tariff1PriceWas.length !== 0) {
        /*main page*/
        this.$tariff1Price = $('.item1.tariff_item .price');
        this.$tariff2Price = $('.item2.tariff_item .price');
        this.$tariff2PriceWas = $('.item2.tariff_item .total_price span');
        this.$tariff3Price = $('.item3.tariff_item .price');
        this.$tariff3PriceWas = $('.item3.tariff_item .total_price span');
    } else {
        /*order page*/
        this.$tariff1Price = $('.info:eq(0) .wrap_btn span');
        this.$tariff2Price = $('.info:eq(1) .wrap_btn span');
        this.$tariff3Price = $('.info:eq(2) .wrap_btn span');
        this.mainPage = false;
    }


    this.renderOptCheckboxes();
    this.calc1TariffPrice();
};

TariffBlock.prototype.toggleRightButtons = function(id) {

    function toggleText(el) {
        if (el.text() == initData.rightButtonText) {
            el.text(initData.rightButtonSelectedText);
        } else {
            el.text(initData.rightButtonText);
        }
    }

    switch (id) {
        case 'option_3':
            toggleText($('#colorCartBtn'));
            break;
        case 'option_4':
            toggleText($('#fontCartBtn'));
            break;
        case 'option_5':
            toggleText($('#brandBtn'));
            break;
    }
};

TariffBlock.prototype.renderOptCheckboxes = function() {
    var self = this;
    $.each(this.optCheckedCollection.collection, function(id, amount) {
        $('input#' + id).click();
        self.toggleRightButtons(id);
    });
};

TariffBlock.prototype.setTariffPrice = function(price, n) {
    this['$tariff' + n + 'Price'].text(getFormatValFromInt(price));
};

TariffBlock.prototype.setTariffPriceWas = function(price, n) {
    this['$tariff' + n + 'PriceWas'].text(getFormatValFromInt(price));
};

TariffBlock.prototype.calc1TariffPrice = function() {
    this.calc1TariffPriceOptions(function(totalOpt) {
        var count = parseInt($logoVarQty.val());
        var total = count * initData.tariff1Price + totalOpt;
        total -= orderForm.couponObj.sum;
        this.setTariffPrice(total, 1);
        if (this.$tariff1PriceWas.length !== 0) {
            var totalWas = count * initData.tariff1PriceWas + totalOpt;
            this.setTariffPriceWas(totalWas, 1);
        }
    }.bind(this));
};

TariffBlock.prototype.calc2TariffPrice = function() {
    var total = initData.tariff2Price - orderForm.couponObj.sum;
    this.setTariffPrice(total, 2);
    if (typeof this.$tariff2PriceWas !== 'undefined' && this.$tariff2PriceWas.length !== 0) {
        var totalWas = initData.tariff2PriceWas - orderForm.couponObj.sum;
        this.setTariffPriceWas(totalWas, 2);
    }
};

TariffBlock.prototype.calc3TariffPrice = function() {
    var total = initData.tariff3Price - orderForm.couponObj.sum;
    this.setTariffPrice(total, 3);
    if (typeof this.$tariff2PriceWas !== 'undefined' && this.$tariff3PriceWas.length !== 0) {
        var totalWas = initData.tariff3PriceWas - orderForm.couponObj.sum;
        this.setTariffPriceWas(totalWas, 3);
    }
};

TariffBlock.prototype.calc1TariffPriceOptions = function(callback) {
    var total = 0;
    $.each(this.optCheckedCollection.collection, function(n, price) {
        total += price;
    });
    callback(total);
};

TariffBlock.prototype.change1TariffPriceOption = function($option) {
    if ($option[0].checked) {
        var price = getIntFromStr($option.parent().find('label[for=' + $option[0].id + '] .optPrice').text());
        this.optCheckedCollection.add($option[0].id, price);
    } else {
        this.optCheckedCollection.remove($option[0].id);
    }
    this.toggleRightButtons($option[0].id);
    localStorage.setItem('optCheckedCollection', JSON.stringify(this.optCheckedCollection.collection));
};
/*==========================END TariffBlock==================================*/



/**
 * @constructor
 */
var OrderForm = function(data) {

    if ('undefined' === typeof data) {
        data = {};
    }
    var self = this;

    if (localStorage.couponObj) {
        this.couponObj = JSON.parse(localStorage.couponObj);
        this.hideForm();
    } else {
        this.couponObj = {
            code: false,
            sum: 0
        };
    }

    this.couponErr = function() {
        $('.couponCode').css('borderColor', '#DD3F3F');
    };

    self.initEvents = function() {
        $(document).on('click', '.sendCode', function() {
            var $coupon = $('.couponCode');
            var coupon = $coupon.val();
            if (coupon.length == 0) {
                self.couponErr();
                return;
            }
            $coupon.css('borderColor', '#5dade2');
            self.sendCouponCode(coupon, function() {});
        });

        $(document).on('keyup', 'input[name=email]', function() {
            $('input[name=email]').val($(this).val());
            $('#order-client_email').val($(this).val());
        });
        $(document).on('keyup', 'input[name=skype]', function() {
            $('input[name=skype]').val($(this).val());
            $('#order-skype').val($(this).val());
        });
        $(document).on('keyup', 'input[name=tel]', function() {
            $('input[name=tel]').val($(this).val());
            $('#order-telephone').val($(this).val());
        });

        $(document).on('change', '#w0 input, #w0 textarea', function() {
            localStorage.setItem('orderForm', self.getJSONFormData());
        });

        $('#w0 input, #w0 textarea').attr("autocomplete", "off");
    };
};

OrderForm.prototype.setJSONFormData = function() {
    if (localStorage.orderForm) {
        var orderForm = JSON.parse(localStorage.orderForm);
        $.each(orderForm, function(id, item) {
            if (item.name != '_csrf') {
                $('[name=\'' + item.name + '\']').val(item.value);
            }
        });
    }
};

OrderForm.prototype.getJSONFormData = function() {
    return JSON.stringify($('#w0').serializeArray());
};

OrderForm.prototype.getStyleObj = function() {
    return {
        hilarity: parseInt($('.hilarity .ui-slider-handle')[0].style.left.replace('%', '')),
        modernity: parseInt($('.modernity .ui-slider-handle')[0].style.left.replace('%', '')),
        minimalism: parseInt($('.minimalism .ui-slider-handle')[0].style.left.replace('%', ''))
    };
};

OrderForm.prototype.getAllData = function() {
    var styles = this.getStyleObj();
    return {
        checkedPortfolioItems: localStorage.checkedPortfolioItems,
        optCheckedCollection: localStorage.optCheckedCollection,
        logoVarQty: localStorage.logoVarQty,
        checkedColors: localStorage.checkedColors,
        styles: styles,
        coupon: localStorage.couponObj
    };
};

OrderForm.prototype.init = function() {
    this.initEvents();
    this.calculateAll();
    this.setJSONFormData();
};

OrderForm.prototype.calculateAll = function() {
    tariffBlock.calc1TariffPrice();
    tariffBlock.calc2TariffPrice();
    tariffBlock.calc3TariffPrice();
};

OrderForm.prototype.hideForm = function() {
    $('.couponHolder').hide();
    $('.couponToggle').hide();
};

OrderForm.prototype.renderForm = function() {
    /*TODO render order form data*/
};

OrderForm.prototype.sendCouponCode = function(code, callback) {
    var self = this;
    $.post(initData.couponCheck, {CouponCode: code}, function(data) {
        if (data.status ==  "success") {
            //Object {status: "success", summ: "500.00"}
            self.couponObj.code = code;
            self.couponObj.sum = data.summ;
            localStorage.setItem('couponObj', JSON.stringify(self.couponObj));
            self.calculateAll();
            self.hideForm();
        } else {
            self.couponErr();
        }
    });
};


$(document).ready(function() {

    window.orderForm = new OrderForm();
    window.tariffBlock = new TariffBlock();
    window.portfolioBlock = new PortfolioBlock();
    window.colorBlock = new ColorBlock();
    orderForm.init();

    renderPortfolioCheckboxes();

    /* === START On portfolio item checkbox click === */
    $(document).on('change', '.logo_item input[type=checkbox]', function() {
        togglePortfolioOrderButtons(this);
    });
    /* === END On portfolio item checkbox click === */

    /* ==== START logo examples quantity === */
    $(document).on('keydown', '.wrap_qty input[type=text]', function(e) {
        if (checkMoveKeyCodes(e)) {
            return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    $(document).on('keyup', '.wrap_qty input[type=text]', function(e) {
        if (checkMoveKeyCodes(e)) {
            return;
        }
        changeLogoVarQty($(this));
    });

    $(document).on('change', '.wrap_qty input[type=text]', function(e) {
        var val = $(this).val();
        if (typeof val == 'undefined' || !val) {
            $(this).val(1);
        }
    });

    $(document).on('click', '.qty_down', function() {
        changeLogoVarQty($logoVarQty, -1);
        tariffBlock.calc1TariffPrice();
    });

    $(document).on('click', '.qty_up', function() {
        changeLogoVarQty($logoVarQty, 1);
        tariffBlock.calc1TariffPrice();
    });
    /* ==== END logo examples quantity === */

    /* ==== START coupon code handlers ==== */
    $(document).on('click', '.couponToggle', function() {
        $(this).hide();
        $('.couponHolder').show();
    });

    $(document).on('click', '.sendCode', function() {
        /*TODO send coupon to validate*/
    });
    /* ==== END coupon code handlers ==== */

    /* === START 1st tariff options handle === */
    $(document).on('change', '.wrap_more_services input', function(evt) {
        tariffBlock.change1TariffPriceOption($(this));
        tariffBlock.calc1TariffPrice();
    });
    $(document).on('change', '.descr .wrap_check input', function(evt) {
        tariffBlock.change1TariffPriceOption($(this));
        tariffBlock.calc1TariffPrice();
    });
    /* === END 1st tariff options handle === */

    /* === START order form right buttons handle === */
    $(document).on('click', '#colorCartBtn', function() {
        $('input#option_3').click();
        return false;
    });

    $(document).on('click', '#fontCartBtn', function() {
        $('input#option_4').click();
        return false;
    });

    $(document).on('click', '#brandBtn', function() {
        $('input#option_5').click();
    });
    /* === END order form right buttons handle === */


    /* === START order form submit === */
    $(document).on('click', '.sub_btn input[type=submit]', function() {
        var data = orderForm.getAllData();
        data.tariff = $(this).attr('rel');
        $('#jsonData').val(JSON.stringify(data));
        return true;
    });
    /* === END order form submit === */


    /*FORM EVENTS*/

    $('form#w0').on('afterValidate', function(form, errors) {
        if (errors['order-client_email'].length > 0) {
            $('input[name=email]').css('borderColor', '#e25d5d');
        } else {
            $('input[name=email]').css('borderColor', '#5dade2');
        }
    });

    window.calcdots = function() {
        $('.more_services label, .wrap_payment .wrap_check label').each(function(id, elem) {
            var $elem = $(elem);
            var fullWidth = $elem.width();
            var fillWidth = $elem.find('.nameOpt').width() + $elem.find('.r_dots').width();
            var diff = fullWidth - fillWidth -5;
            $elem.find('.dots').width(diff);
        });
    };

    setTimeout(calcdots, 200);

});