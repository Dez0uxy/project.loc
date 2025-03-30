<?php
/* @var $this yii\web\View */
/* @var $model common\models\FilterAuto */
/* @var $form yii\widgets\ActiveForm */

use kartik\depdrop\DepDrop;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->registerJs(
    '$("document").ready(function(){
            $("#new_item").on("pjax:end", function() {
            $.pjax.reload({container:"#applicability"});  //Reload GridView
        });
    });'
);

$modelName = str_replace('_', '', $model::tableName());
?>
<div class="filter-auto-form">

    <?php Pjax::begin(['id' => 'new_item']) ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>

    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'vendor')->dropdownList([null => ''] + $model::getVendorArray()) ?>
        </div>
        <div class="col-lg-8">
            <?= $form->field($model, 'model_year_engine')->widget(DepDrop::classname(), [
                'data'           => [],
                'options'        => ['placeholder' => ''],
                'type'           => DepDrop::TYPE_SELECT2,
                'select2Options' => ['pluginOptions' => ['allowClear' => false]],
                'pluginOptions'  => [
                    'depends'     => [$modelName.'-vendor'],
                    'url'         => Url::to(['/filter-auto/get-model-year-engine']),
                    'loadingText' => '...',
                ]
            ]); ?>
        </div>
        <?= $form->field($model, 'model')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'year')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'engine')->hiddenInput()->label(false) ?>
        <div class="col-lg-1 pt-5">
            <?= Html::submitButton('<i class="fa fa-save"></i>', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <div class="form-group">
        
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>

<script>
    function vendorSelected($e) {
        $.ajax({
            url: '<?= Url::to(['filter-auto/get-models-by-vendor'])?>?vendor=' + encodeURIComponent($(this).val()),
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

    $(document).on('ready pjax:success', function(){
        $('#<?= $modelName ?>-vendor').on('typeahead:selected', vendorSelected);
        $('#<?= $modelName ?>-vendor').on('typeahead:autocompleted', vendorSelected);
    });
    $('#<?= $modelName ?>-vendor').on('typeahead:selected', vendorSelected);
    $('#<?= $modelName ?>-vendor').on('typeahead:autocompleted', vendorSelected);

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
