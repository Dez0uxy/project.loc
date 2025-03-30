<?php

use kartik\typeahead\TypeaheadBasic;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\widgets\Pjax;

$this->registerJs(
    '$("document").ready(function(){
            $("#new_item").on("pjax:end", function() {
            $.pjax.reload({container:"#applicability"});  //Reload GridView
        });
    });'
);

/* @var $this yii\web\View */
/* @var $model common\models\FilterAuto */
/* @var $form yii\widgets\ActiveForm */

$modelName = str_replace('_', '', $model::tableName());
?>

<div class="filter-auto-form">

    <?php Pjax::begin(['id' => 'new_item']) ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>
    
    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'vendor')->widget(TypeaheadBasic::classname(), [
                'data'          => $model::getVendorArray(),
                'options'       => ['placeholder' => '...'],
                'pluginOptions' => ['highlight' => true, 'minLength' => 0],
            ]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'model')->textInput(['maxlength' => true, 'placeholder' => '...']) ?>
        </div>

        <div class="col-lg-3">
            <?= $form->field($model, 'year')->textInput(['maxlength' => true, 'placeholder' => '1996;1997;1998;1999;2000']) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'engine')->textInput(['maxlength' => true, 'placeholder' => '2.4;3.3;3.8']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i>', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>

<script>
    function vendorSelected($e) {
        $.ajax({
            url: '<?= \yii\helpers\Url::to(['filter-auto/get-models-by-vendor'])?>?vendor=' + encodeURIComponent($(this).val()),
            success: function (data, textStatus, jqXHR) {
                if (data) {
                    $("#<?= $modelName ?>-model").val('')
                    $("#<?= $modelName ?>-model").typeahead('destroy');

                    $('#<?= $modelName ?>-model').typeahead(
                        {"highlight":true,"minLength":0}, 
                        {"name":"<?= $modelName ?>-model-th","source": substringMatcher(data)}
                    );
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Помилка загрузки')
            }
        });
    }
    function modelSelected($e) {
        $.ajax({
            url: '<?= \yii\helpers\Url::to(['filter-auto/get-years-by-vendor-model'])?>?vendor=' + encodeURIComponent($('#<?= $modelName ?>-vendor').val()) + '&model=' + encodeURIComponent($(this).val()),
            success: function (data, textStatus, jqXHR) {
                if (data) {
                    $("#<?= $modelName ?>-year").val('')
                    $("#<?= $modelName ?>-year").typeahead('destroy');

                    $('#<?= $modelName ?>-year').typeahead(
                        {"highlight":true,"minLength":0},
                        {"name":"<?= $modelName ?>-year-th","source": substringMatcher(data)}
                    );
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Помилка загрузки')
            }
        });

        $.ajax({
            url: '<?= \yii\helpers\Url::to(['filter-auto/get-engine-by-vendor-model'])?>?vendor=' + encodeURIComponent($('#<?= $modelName ?>-vendor').val()) + '&model=' + encodeURIComponent($(this).val()),
            success: function (data, textStatus, jqXHR) {
                if (data) {
                    $("#<?= $modelName ?>-engine").val('')
                    $("#<?= $modelName ?>-engine").typeahead('destroy');

                    $('#<?= $modelName ?>-engine').typeahead(
                        {"highlight":true,"minLength":0},
                        {"name":"<?= $modelName ?>-engine-th","source": substringMatcher(data)}
                    );
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Помилка загрузки')
            }
        });
    }

    $(document).on('ready pjax:success', function(){
        $('#<?= $modelName ?>-vendor').on('typeahead:selected', vendorSelected);
        $('#<?= $modelName ?>-vendor').on('typeahead:autocompleted', vendorSelected);

        $('#<?= $modelName ?>-model').on('typeahead:selected', modelSelected);
        $('#<?= $modelName ?>-model').on('typeahead:autocompleted', modelSelected);
    });
    $('#<?= $modelName ?>-vendor').on('typeahead:selected', vendorSelected);
    $('#<?= $modelName ?>-vendor').on('typeahead:autocompleted', vendorSelected);

    $('#<?= $modelName ?>-model').on('typeahead:selected', modelSelected);
    $('#<?= $modelName ?>-model').on('typeahead:autocompleted', modelSelected);

    let substringMatcher = function(strs) {
        return function findMatches(q, cb) {
            let matches, substringRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function(i, str) {
                if (substrRegex.test(str)) {
                    matches.push(str);
                }
            });

            cb(matches);
        };
    };

</script>
