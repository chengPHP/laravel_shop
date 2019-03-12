/**
 * Created by CCM on 2018/8/10.
 */
var blog = function(){


    var handleiCheck = function() {
        if (!$().iCheck) {
            return;
        }

        $('.radio_input').on('ifCreated ifClicked ifChanged ifChecked ifUnchecked ifDisabled ifEnabled ifDestroyed', function(event){
        }).iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%'
        });

    };

    var handleCheckAll = function(){
        if (!$().iCheck) {
            return;
        }

           $('.icheck_input_all').on('ifChecked', function(event){
               $('.icheck_input').iCheck('check')
           });

        //全不选
           $('.icheck_input_all').on('ifUnchecked', function(event){
               $('.icheck_input').iCheck('uncheck')
           });
    };


    return {


        //main function to initiate core javascript
        init:function (){
            handleiCheck();
            handleCheckAll();
        },
        //main function to initiate core javascript after ajax complete
        initAjax:function (){
            handleiCheck();
            handleCheckAll();
        },

        handleCheckAll : function(){
            $('.icheck_input_all').on('ifChecked', function(event){
                $('.icheck_input').iCheck('check')
            });
            //全不选
            $('.icheck_input_all').on('ifUnchecked', function(event){
                $('.icheck_input').iCheck('uncheck')
            });
        },

        handleiCheck : function() {
            if ($().iCheck()) {
                $('.icheck_input').on('ifCreated ifClicked ifChanged ifChecked ifUnchecked ifDisabled ifEnabled ifDestroyed', function (event) {
                }).iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%'
                });
            }

        },

        loading: function (message) {
            $('body').loading({
                loadingWidth:240,
                title:'',
                name:'loading',
                discription:message,
                direction:'column',
                type:'origin',
                // originBg:'#71EA71',
                originDivWidth:40,
                originDivHeight:40,
                originWidth:6,
                originHeight:6,
                smallLoading:false,
                loadingMaskBg:'rgba(0,0,0,0.2)'
            });
        },

        handleSelect2 : function() {
            if ($().select2) {
                $.fn.select2.defaults.set("theme", "bootstrap");
                $('.select2').select2({
                    width: '100%'
                });
            }
        },

        initSlimScroll: function(el) {
            if (!$().slimScroll) {
                return;
            }

            $(el).each(function() {
                if ($(this).attr("data-initialized")) {
                    return; // exit
                }

                var height = '100%';

                if ($(this).attr("data-height")) {
                    height = $(this).attr("data-height");
                }

                $(this).slimScroll({
                    allowPageScroll: true, // allow page scroll when the element scroll is ended
                    size: '7px',
                    color: ($(this).attr("data-handle-color") ? $(this).attr("data-handle-color") : 'rgb(0, 0, 0)'),
                    wrapperClass: ($(this).attr("data-wrapper-class") ? $(this).attr("data-wrapper-class") : 'slimScrollDiv'),
                    railColor: ($(this).attr("data-rail-color") ? $(this).attr("data-rail-color") : '#eaeaea'),
                    position: 'right',
                    height: height,
                    alwaysVisible: ($(this).attr("data-always-visible") == "1" ? true : false),
                    railVisible: ($(this).attr("data-rail-visible") == "1" ? true : false),
                    disableFadeOut: true
                });

                $(this).attr("data-initialized", "1");
            });
        },

        errorPrompt: function(jqXHR, textStatus, errorThrown){
            if(jqXHR.status == 422) {
                var arr = "";
                for (var i in jqXHR.responseJSON) {
                    if (i == "errors") {
                        var xarr = jqXHR.responseJSON[i];
                        for (var j in xarr) {
                            var str = xarr[j];
                            for (k = 0; k < str.length; k++) {
                                arr += str[k] + ",";
                            }
                        }
                    }
                }
                swal("", arr.substring(0, arr.length - 1), "error");
            }
        }
    }
}();

jQuery(document).ready(function() {
    // blog.init();
});