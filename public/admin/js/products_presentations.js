
let presentationsForm = `
    <form style="text-align:left;" id="presentationsForm">
        <br>
        <label>Presentación</label>
        <input class="form-control input-lg" id="pres_presentation" name="presentation" value="" type="text">
        <br>
        <label>$ Precio</label>
        <div class="input-group">
            <input type="number" placeholder="00.00" name="price" id="pres_price" value="" class="form-control">
        </div>
        <br>
        <label>$ Precio promo</label>
        <div class="input-group">
            <input type="number" placeholder="00.00" name="promo_price" id="pres_promo_price" value="" class="form-control">
        </div>
        <br>
        <div class="checkbox">
            <label>
            <input name="pres_offer" id="pres_offer" value="" type="checkbox"> Oferta
            </label>
        </div>
        <br>
        <div class="checkbox">
            <label>
            <input name="pres_highlighted" id="pres_highlighted" value="" type="checkbox"> Destacado
            </label>
        </div>
        <br>
        <label>Stock (Cantidad)</label>
        <div class="input-group">
            <input type="number" placeholder="00" id="pres_stock" value="" class="form-control">
        </div>
        <input type="hidden" id="presNum" name="presNum" value=""/>
    </form>`;

function savePres() {
    let presentation = {
        'main': ($('#presNum').val() !== '') ? presentations[$('#presNum').val()].main : (presentations.length == 0) ? 1 : 0,
        'presentation': ($('#pres_presentation').val()).trim(),
        'price': $('#pres_price').val(),
        'promo_price': $('#pres_promo_price').val(),
        'offer': $('#pres_offer').is(':checked'),
        'highlighted': $('#pres_highlighted').is(':checked'),
        'stock': $('#pres_stock').val(),
    };
    if ($('#presNum').val() !== '') {
        presentations[$('#presNum').val()] = presentation;
    } else {
        presentations.push(presentation);
    }
    renderPres();
}

window.onload = function () {
    renderPres();
}

function renderPres() {
    let html = '';
    if (presentations.length > 0) {
        html = `
<table border='1' style='width:90%';>
    <thead>
        <tr>
            <th>Default</th>
            <th>Presentación</th>
            <th>Precio</th>
            <th>Precio Promo</th>
            <th>Es oferta</th>
            <th>Es destacado</th>
            <th>Stock</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>`;
        presentations.forEach(function (presentation, i) {
            let offer = presentation.offer == true ? 'Si' : 'No';
            let highlighted = presentation.highlighted == true ? 'Si' : 'No';
            let checked = presentation.main == 1 ? 'checked' : '';
            html += `<tr>
                            <td><input ${ checked} type="radio" onclick="setMain(${i})" name="default"/></td>
                            <td>${ presentation.presentation}</td>
                            <td>${ presentation.price}</td>
                            <td>${ presentation.promo_price}</td>
                            <td>${ offer}</td>
                            <td>${ highlighted}</td>
                            <td>${ presentation.stock}</td>
                            <td style='width:10%;'>
                                <a href='#' onclick='deletePres(${ i });'><span class='badge bg-red'>Eliminar</span></a>
                                <a href='#' onclick='showPresForm(${ i });'><span class='badge bg-green'>Editar</span></a>
                            </td>
                        </tr>`;
        });
        html += "</tbody></table>";
    } else {
        html = 'Aun no hay presentaciones cargadas';
    }
    $("#presentationContent").html(html);
    $("#presentations").val(JSON.stringify(presentations));
}

function deletePres(param) {
    Swal.fire({
        text: "Seguro eliminar?",
        confirmButtonText: "Si, eliminar",
        showCancelButton: true,
        closeOnConfirm: false,
    }).then((result) => {
        if (result.value == true) {
            presentations.splice(param, 1);
            renderPres();
        };
    });
}

function setMain(param) {
    presentations.forEach(function (presentation) {
        presentation.main = 0;
    })
    presentations[param].main = 1;
    $("#presentations").val(JSON.stringify(presentations));
}

function showPresForm(param) {
    Swal.fire({
        title: "<i style='font-size:25px;' >Presentaciones del producto</i>",
        html: presentationsForm,
        confirmButtonText: (param !== false) ? "Aplicar" : "Agregar +",
        closeOnConfirm: false,
        showCancelButton: true,
    }).then((result) => {
        if (result.value == true) {
            savePres();
        };
    });
    if (param !== false){
        $('#pres_presentation').val(presentations[param].presentation);
        $('#pres_price').val(presentations[param].price);
        $('#pres_promo_price').val(presentations[param].promo_price);
        $('#pres_offer')[0].checked = presentations[param].offer;
        $('#pres_highlighted')[0].checked = presentations[param].highlighted;
        $('#pres_stock').val(presentations[param].stock);
        $('#presNum').val(param);
    }  
}
