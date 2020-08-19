<?php
/* @var $this MenuController */
/* @var $model CylTables*/

$this->pageTitle = 'Create Parent Menu Item';
?>
<div class="block">
    <div class="block-header bg-gray-lighter">
        <h3 class="block-title" style="padding-bottom: 10px;">non-CRUD menu item</h3>
    </div>
    <form id="parent_item_form" name="parent_item" action="<?php echo Yii::app()->createUrl('admin/menu/update/'.$model->table_id); ?>" method="post">
        <div class="block-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6" style="padding-bottom: 10px;">
                        <label>Icon</label>
                        <div class="input-group iconpicker-container">
                            <input class="form-control icp icp-auto" value="<?php echo substr($model->menu_icon, 2) ?>" name="ParentItem[MenuIcon]" id="menu_icon"/>
                            <span class="input-group-addon"></span>
                        </div>
                    </div>
                    <div class="col-md-6" style="padding-bottom: 10px;">
                        <label>Title</label>
                        <input type="text" class="form-control" value="<?php echo $model->table_name?>" name="ParentItem[Title]" id="title" disabled>
                    </div>
                    <div class="col-md-6" style="padding-bottom: 10px;">
                        <label>Visual Title</label>
                        <input type="text" class="form-control" value="<?php echo $model->menu_name?>" name="ParentItem[Visual-Title]" id="visual_title">
                    </div>
                </div>
                <input class="btn btn-primary" type="submit" value="Save" style="float: right">
            </div>
        </div>
    </form>
</div>
<script>
    $(function() {
        $('.icp-auto').iconpicker();

        $('#menu_icon').bind('keypress', function(e) {
            e.stopPropagation();
        });
    });
    $(document).ready(function () {
        $("#menu_icon").keydown(function(e){
            e.preventDefault();
        });
    });

    $(document).ready(function () {
        // field_name regular expression validation
        $.validator.addMethod("fieldNameRegex", function (value, element, regexpr) {
            return regexpr.test(value);
        }, "Only '-'(dash) and '_'(underscore) special characters are allow ");

        $("#parent_item_form").validate({
            debug: true,
            errorClass: "help-block text-right",
            errorElement: "div",
            onfocusout: false,
            onkeyup: false,
            rules: {
                "ParentItem[Title]": {
                    required: true
                },
                "ParentItem[Visual-Title]": {
                    required: true
                }
            },
            messages: {
                "ParentItem[Title]": {
                    required: 'Please enter Title'
                },
                "ParentItem[Visual-Title]": {
                    required: 'Please enter visual title'
                }
            },
            highlight: function (element, errorClass) {
                $(element).removeClass(errorClass);
                $(element).parent().addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).parent().removeClass('has-error');
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });

    $("#title").keyup(function () {
        var str = $("#title").val();
        $("#visual_title").val(str);
    });
</script>