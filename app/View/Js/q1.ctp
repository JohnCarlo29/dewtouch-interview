<div class="alert  ">
    <button class="close" data-dismiss="alert"></button> Question: Advanced Input Field
</div>
<p>
    1. Make the Description, Quantity, Unit price field as text at first. When user clicks the text, it changes to input field for use to edit. Refer to the following video.
</p>

<p>
    2. When user clicks the add button at left top of table, it wil auto insert a new row into the table with empty value. Pay attention to the input field name. For example the quantity field
    <?php echo htmlentities('<input name="data[1][quantity]" class="">') ?> , you have to change the data[1][quantity] to other name such as data[2][quantity] or data["any other not used number"][quantity]
</p>

<div class="alert alert-success">
    <button class="close" data-dismiss="alert"></button>
    The table you start with
</div>
<style>
    .invoice-table tr td {
        padding: 10px;
    }

    .invoice-table tr input,
    .invoice-table tr textarea {
        width: 100%;
        display: none;
        box-sizing: border-box;
        min-height: 30px;
    }

    .invoice-table tr .placeholder {
        display: inline-block;
        min-height: 40px;
        width: 100%;
        cursor: pointer;

    }

    .invoice-table .baseRow {
        display: none;
    }
</style>
<table class="table table-striped table-bordered table-hover invoice-table">
    <thead>
        <th>
            <span id="add_item_button" class="btn mini green addbutton" onclick="addToObj=false">
                <i class="icon-plus"></i>
            </span>
        </th>
        <th width="30%">Description</th>
        <th width="30%">Quantity</th>
        <th width="30%">Unit Price</th>
    </thead>
    <tbody>
        <tr class="baseRow">
            <td>
                <span class="btn mini btn-delete">
                    <strong>X</strong>
                </span>
            </td>
            <td>
                <div class="input-group mb-3">
                    <span class="description-placeholder placeholder"></span>
                    <textarea name="data[1][description]" class="m-wrap description form-control required" rows="2"></textarea>
                </div>
            </td>
            <td>
                <div class="input-group mb-3">
                    <span class="quantity-placeholder placeholder"></span>
                    <input type="text" name="data[1][quantity]" class="form-control" />
                </div>
            </td>
            <td>
                <div class="input-group mb-3">
                    <span class="unit_price-placeholder placeholder"></span>
                    <input type="text" name="data[1][unit_price]" class="form-control">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <span class="btn mini btn-delete">
                    <strong>X</strong>
                </span>
            </td>
            <td>
                <div class="input-group mb-3">
                    <span class="description-placeholder placeholder"></span>
                    <textarea name="data[1][description]" class="m-wrap description form-control required" rows="2"></textarea>
                </div>
            </td>
            <td>
                <div class="input-group mb-3">
                    <span class="quantity-placeholder placeholder"></span>
                    <input type="text" name="data[1][quantity]" class="form-control" />
                </div>
            </td>
            <td>
                <div class="input-group mb-3">
                    <span class="unit_price-placeholder placeholder"></span>
                    <input type="text" name="data[1][unit_price]" class="form-control">
                </div>
            </td>
        </tr>
    </tbody>
</table>
<p></p>
<div class="alert alert-info ">
    <button class="close" data-dismiss="alert"></button> Video Instruction
</div>
<p style="text-align:left;">
    <video width="78%" controls>
        <source src="/video/q3_2.mov" />
        Your browser does not support the video tag.
    </video>
</p>

<?php $this->start('script_own'); ?>
<script>
    $(document).ready(function() {
        $("#add_item_button").click(function() {
                let totalRow = $('.invoice-table >tbody >tr').length - 1; //excluded the base row
                let newRow = $('.invoice-table .baseRow').html().replace(/[1]/g, (totalRow + 1));
                $('.invoice-table tbody').append('<tr>'+newRow+'</tr>');
        });

        $(document).on('click', '.invoice-table tr .placeholder', function(event) {
            $(this).hide();
            $(this).siblings().show();
            $(this).siblings().focus();
        });

        $(document).on('click', '.invoice-table tr .btn-delete', function(event) {
            $(this).parent().parent().remove();
        });

        $(document).on('blur', '.invoice-table tr .form-control', function(event) {
            $(this).hide();
            $(this).siblings().show();
            $(this).siblings().html($(this).val());
        });
    });
</script>
<?php $this->end(); ?>