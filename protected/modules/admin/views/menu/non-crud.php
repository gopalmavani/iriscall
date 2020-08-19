<?php
/* @var $this MenuController */
/* @var $model CylTables*/

$this->pageTitle = 'Create Non-CRUD Item';
?>
<div class="block">
    <div class="block-header bg-gray-lighter">
        <h3 class="block-title" style="padding-bottom: 10px;">non-CRUD menu item</h3>
    </div>
    <form id="non_crud_item_form" name="non-crud-item" action="<?php echo Yii::app()->createUrl('admin/menu/create/1'); ?>" method="post">
    <div class="block-content">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6" style="padding-bottom: 10px;">
                    <label>Parent Menu Item</label>
                    <select class="form-control" name="NonCrud[ParentMenuItem]" id="parent_menu_item">
                        <option value="" disabled selected>Optinal Selection</option>
                        <?php
                        foreach ($parents as $key => $parent){ ?>
                            <option value="<?php echo $parent->table_id; ?>"><?php echo $parent->menu_name; ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
                <div class="col-md-6" style="padding-bottom: 10px;">
                    <label>Icon</label>
                    <div class="input-group iconpicker-container">
                        <input class="form-control icp icp-auto" value="fa-user" name="NonCrud[MenuIcon]" id="menu_icon"/>
                        <span class="input-group-addon"></span>
                    </div>
                </div>
                <div class="col-md-6" style="padding-bottom: 10px;">
                    <label>Title</label>
                    <input type="text" class="form-control" name="NonCrud[Title]" id="title">
                </div>
                <div class="col-md-6" style="padding-bottom: 10px;">
                    <label>Visual Title</label>
                    <input type="text" class="form-control" name="NonCrud[Visual-Title]" id="visual_title">
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

        $("#non_crud_item_form").validate({
            debug: true,
            errorClass: "help-block text-right",
            errorElement: "div",
            onfocusout: false,
            onkeyup: false,
            rules: {
                "NonCrud[ParentMenuItem]": {
                    required: false
                },
                "NonCrud[MenuIcon]": {
                    required: false
                },
                "NonCrud[Title]": {
                    required: true
                },
                "NonCrud[Visual-Title]": {
                    required: true
                }
            },
            messages: {
                "NonCrud[ParentMenuItem]": {
                    required: false
                },
                "NonCrud[MenuIcon]": {
                    required: 'Please enter menu icon'
                },
                "NonCrud[Title]": {
                    required: 'Please enter Title'
                },
                "NonCrud[Visual-Title]": {
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

</script>