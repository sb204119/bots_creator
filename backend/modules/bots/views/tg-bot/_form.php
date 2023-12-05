<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\bots\models\TgBot */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tg-bot-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'service_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bot_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'welcome_message')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <label class="control-label">Keyboard Type</label>
        <select id="keyboard-type" class="form-control">
            <option value="reply">Reply Keyboard</option>
            <option value="inline">Inline Keyboard</option>
        </select>
    </div>

    <div class="form-group" id="reply-keyboard-section">
        <label class="control-label">Reply Keyboard Buttons</label>
        <div class="row" id="reply-buttons">
            <!-- Кнопки репли будут отображаться здесь -->
        </div>
        <div class="input-group">
            <input type="text" class="form-control" id="reply-button-text" placeholder="Button Text">
            <input type="text" class="form-control" id="reply-button-command" placeholder="Button Command">
            <span class="input-group-btn">
                <button type="button" class="btn btn-success" id="add-reply-button">Add Reply Button</button>
            </span>
        </div>
    </div>

    <div class="form-group" id="inline-keyboard-section" style="display: none;">
        <label class="control-label">Inline Keyboard Buttons</label>
        <div class="row" id="inline-buttons">
            <!-- Кнопки инлайн будут отображаться здесь -->
        </div>
        <div class="input-group">
            <input type="text" class="form-control" id="inline-button-text" placeholder="Button Text">
            <input type="text" class="form-control" id="inline-button-command" placeholder="Button Command">
            <span class="input-group-btn">
                <button type="button" class="btn btn-success" id="add-inline-button">Add Inline Button</button>
            </span>
        </div>
    </div>

    <?= $form->field($model, 'menu')->hiddenInput(['id' => 'tgbot-menu'])->label(false) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'webhook_url')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('frontend', 'Save'), ['class' => 'btn btn-success', 'id' => 'submit-button']) ?>
    </div>

    <script>
        $(document).ready(function() {
            // Обработчик изменения выбора типа клавиатуры
            $('#keyboard-type').on('change', function() {
                var selectedType = $(this).val();
                if (selectedType === 'reply') {
                    $('#reply-keyboard-section').show();
                    $('#inline-keyboard-section').hide();
                } else if (selectedType === 'inline') {
                    $('#reply-keyboard-section').hide();
                    $('#inline-keyboard-section').show();
                }
            });

            // Распаковка JSON-строки в массив объектов (для кнопок репли и инлайн)
            var menuData = <?= $model->menu ? json_encode(json_decode($model->menu, true)) : '[]' ?>;
            var replyButtons = menuData.filter(button => button.type === 'reply');
            var inlineButtons = menuData.filter(button => button.type === 'inline');

            function displayReplyButtons() {
                var replyButtonsHtml = '';
                replyButtons.forEach(function(button, index) {
                    replyButtonsHtml += '<div class="col-md-2">' +
                        '<div class="box box-primary button-style" data-toggle="tooltip" data-placement="top" title="Command: ' + button.command + '">' +
                        '<div class="box-header">' +
                        '<h3 class="box-title">' + button.text + '</h3>' +
                        '<div class="box-tools pull-right">' +
                        '<button type="button" class="btn btn-danger btn-xs remove-reply-button" data-index="' + index + '">Remove</button>' +
                        '</div>' +
                        '</div></div></div>';
                });
                $('#reply-buttons .col-md-2').remove();
                $('#reply-buttons').append(replyButtonsHtml);
                $('[data-toggle="tooltip"]').tooltip();
            }

            function displayInlineButtons() {
                var inlineButtonsHtml = '';
                inlineButtons.forEach(function(button, index) {
                    inlineButtonsHtml += '<div class="col-md-2">' +
                        '<div class="box box-primary button-style" data-toggle="tooltip" data-placement="top" title="Command: ' + button.command + '">' +
                        '<div class="box-header">' +
                        '<h3 class="box-title">' + button.text + '</h3>' +
                        '<div class="box-tools pull-right">' +
                        '<button type="button" class="btn btn-danger btn-xs remove-inline-button" data-index="' + index + '">Remove</button>' +
                        '</div>' +
                        '</div></div></div>';
                });
                $('#inline-buttons .col-md-2').remove();
                $('#inline-buttons').append(inlineButtonsHtml);
                $('[data-toggle="tooltip"]').tooltip();
            }

            // Вызываем функции для отображения кнопок
            displayReplyButtons();
            displayInlineButtons();

            // Добавление кнопок репли и инлайн
            $('#add-reply-button').on('click', function() {
                var replyButtonText = $('#reply-button-text').val();
                var replyButtonCommand = $('#reply-button-command').val();
                if (replyButtonText && replyButtonCommand) {
                    replyButtons.push({ text: replyButtonText, command: replyButtonCommand, type: 'reply' });
                    displayReplyButtons();
                    $('#reply-button-text').val('');
                    $('#reply-button-command').val('');
                }
            });

            $('#add-inline-button').on('click', function() {
                var inlineButtonText = $('#inline-button-text').val();
                var inlineButtonCommand = $('#inline-button-command').val();
                if (inlineButtonText && inlineButtonCommand) {
                    inlineButtons.push({ text: inlineButtonText, command: inlineButtonCommand, type: 'inline' });
                    displayInlineButtons();
                    $('#inline-button-text').val('');
                    $('#inline-button-command').val('');
                }
            });

            // Удаление кнопок репли и инлайн
            $(document).on('click', '.remove-reply-button', function() {
                var index = $(this).data('index');
                replyButtons.splice(index, 1);
                displayReplyButtons();
            });

            $(document).on('click', '.remove-inline-button', function() {
                var index = $(this).data('index');
                inlineButtons.splice(index, 1);
                displayInlineButtons();
            });

            $('#submit-button').on('click', function() {
                var allButtons = replyButtons.concat(inlineButtons);
                $('#tgbot-menu').val(JSON.stringify(allButtons));
            });
        });
    </script>

    <?php ActiveForm::end(); ?>
</div>
