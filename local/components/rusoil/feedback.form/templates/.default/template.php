<?php
use Bitrix\Main\UI\Extension;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
Extension::load('ui.bootstrap4'); ?>
<div class="container">
    <form id="contact-form">
        <div class="form-row">
            <h1>
                Новая заявка
            </h1>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="font-weight-bold" for="inputEmail4">Заголовок заявки</label>
                <input type="text" class="form-control" name="title" id="inputEmail4" placeholder="Заголовок заявки" required>
            </div>
        </div>
        <br>
        <div class="form-row">
            <div class="form-group">
                <label class="font-weight-bold" for="inputPassword4">Категория</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="category" value="1" id="flexRadioDefault1">
                    <label class="form-check-label" for="flexRadioDefault1">
                        Масла, автохимия, фильтры, автоаксессуары, обогреватели, запчасти, сопутствующие товары
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="category" value="2" id="flexRadioDefault2" checked>
                    <label class="form-check-label" for="flexRadioDefault2">
                        Шины, диски
                    </label>
                </div>
            </div>
        </div>
        <br>
        <div class="form-row">
            <div class="form-group">
                <label class="font-weight-bold" for="inputAddress">Вид заявки</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="type_feed" value="1" id="flexRadioDefault3">
                    <label class="form-check-label" for="flexRadioDefault3">
                        Запрос цены и сроков поставки
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="type_feed" value="2" id="flexRadioDefault4" checked>
                    <label class="form-check-label" for="flexRadioDefault4">
                        Пополнение складов
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="type_feed" value="3" id="flexRadioDefault5">
                    <label class="form-check-label" for="flexRadioDefault5">
                        Спецзаказ
                    </label>
                </div>
            </div>
        </div>
        <br>
        <div class="form-row">
            <div class="form-group">
                <label class="font-weight-bold" for="inputAddress2">Склад поставки</label>
                <select name="store" class="form-select" aria-label="Default select example">
                    <option value="0" selected>Выберите склад поставки</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
        </div>
        <br>
        <div class="form-row">
            <div class="form-group" id="append">
                <b>Состав заявки</b>
                <div class="input-group justify-content-between">
                    <div class="form-group col-md-2 input-group-prepend">
                        <label for="brand">Бренд</label>
                        <select class="form-select" name="brand[]" id="brand" aria-label="Default select example">
                            <option value="0" selected>Выберите бренд</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="nomination">Наименование</label>
                        <input type="text" class="form-control" name="nomination[]" id="nomination">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="count">Количество</label>
                        <input type="text" class="form-control" name="count[]"  id="count">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="packaging">Фасовка</label>
                        <input type="text" class="form-control" name="packaging[]" id="packaging">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputZip">Клиент</label>
                        <input type="text" class="form-control" name="client[]" id="client">
                    </div>
                    <button class="btn btn-outline-primary add" id="add_row"> Добавить
                    </button>
                </div>
            </div>
        </div>
        <br>
        <div class="form-group">
            <input class="form-control" type="file" name="file[]" id="formFile" multiple>
        </div>
        <div class="form-group">
            <label class="font-weight-bold" for="comment">Комментарий</label>
            <textarea class="form-control" id="comment" rows="3"></textarea>
        </div>
        <br>
        <button id="send" type="submit" class="btn btn-primary">Отправить</button>
    </form>
</div>

<div id="result"></div>

<script>
    let count = 1;
    let form = document.getElementById('contact-form')

    $('#contact-form').submit(function(event) {
        event.preventDefault();
        let data = new FormData(form);
        data.append('rows', count);

        BX.ajax.runComponentAction('rusoil:feedback.form', 'submitForm', {
            mode: 'class',
            method: 'post',
            data: data,
            onsuccess: function(result) {
                $('#result').html("Сообщение успешно отправлено!");
            },
            onfailure: function(err) {
                console.log(err);
            }
        });
    });

    $(document).ready(function() {

        $('#add_row').click(function() {
            //Add row
            let row = '<div class="input-group justify-content-between remove-me"> <div class="form-group col-md-2 input-group-prepend"> <label for="inputCity">Бренд</label> <select class="form-select" name="brand[]" aria-label="Default select example"> <option selected>Выберите бренд</option> <option value="1">One</option> <option value="2">Two</option> <option value="3">Three</option></select> </div> <div class="form-group col-md-2"> <label for="nomination'+count+'">Наименование</label> <input type="text" class="form-control" name="nomination[]" id="nomination'+count+'"> </div> <div class="form-group col-md-2"> <label for="count'+count+'">Количество</label> <input type="text" class="form-control" name="count[]" id="count'+count+'"> </div> <div class="form-group col-md-2"> <label for="packaging'+count+'">Фасовка</label> <input type="text" class="form-control" name="packaging[]"  id="packaging'+count+'"> </div> <div class="form-group col-md-2"> <label for="client'+count+'">Клиент</label> <input type="text" class="form-control" name="client[]" id="client'+count+'"> </div> <button class="btn btn-outline-danger delete_row"> Удалить </button> </div>';
            count++;
            $("#append").append(row);
        })

        $("#append").on('click', '.delete_row', function() {
            $(this).closest('.remove-me').remove();
        });

    });
</script>
