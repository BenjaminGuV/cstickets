const input_cantidad        = document.getElementById("cantidad");
const input_nombre          = document.getElementById("nombre");
const input_precioxunidad   = document.getElementById("precioxunidad");
const input_precioxcantidad = document.getElementById("precioxcantidad");
const button_add            = document.getElementById("add-acc-tickets");
const append_table          = document.getElementById('append-table');
const button_save_tickets   = document.getElementById("form-save-tickets");

const cont_subtotal = document.getElementById('cont-subtotal');
const cont_iva      = document.getElementById('cont-iva');
const cont_total    = document.getElementById('cont-total');

let list_product = [];
let total        = 0;
let subtotal     = 0;
let iva          = 0;


(function() {

    const datas = new FormData();
    datas.append('action', 'save_cstickets_ajax');

    this.path_ajax = localize_vars.url + "wp-admin/admin-ajax.php";

    /*
    postData( this.path_ajax , datas)
    .then( data => {
        // JSON data parsed by `data.json()` call
        console.log( "data", data );
    })
    .catch( 
        error => { console.error('Error:', error ) }
    );
    */

    const select_code_list = document.getElementById("sel-code-list");

    //plugins debug
    //var options = {searchable: true};
    //NiceSelect.bind( select_code_list, options );

    select_code_list.addEventListener('change', (event) => {
        console.log( `Te gusta el sabor ${event.target.value}` );
        console.log( event.target.value, event.target );
        dataProducts( event.target.value );
    });

    button_save_tickets.addEventListener('click', (event) => {
        event.preventDefault();

        console.log("------");
        console.log("subtotal", subtotal);
        console.log("iva", iva);
        console.log("total", total);

        var data_tickets = new FormData();
        data_tickets.append('action', 'save_cstickets_ajax');
        data_tickets.append('subtotal', subtotal);
        data_tickets.append('iva', iva);
        data_tickets.append('total', total);
        
        for (var i = 0; i < list_product.length; i++) {
            data_tickets.append('list_product[]', JSON.stringify(list_product[i]) );
        }

        console.log( "data_tickets", data_tickets );

        this.path_ajax = localize_vars.url + "wp-admin/admin-ajax.php";

        postData( this.path_ajax , data_tickets)
        .then( data => {
            // JSON data parsed by `data.json()` call
            console.log( "data", data );
            if ( data.status == "OK" ) {
                alert( "Se ha creado exitosamente" );
                location.reload();
            }
        })
        .catch( 
            error => { console.error('Error:', error, data_tickets ) }
        );

    });

})();

function dataProducts( id_product ) {
    this.id_product = id_product;

    const datas = new FormData();
    datas.append('action', 'get_cstickets_ajax');
    datas.append('id_product', this.id_product);
    
    this.path_ajax = localize_vars.url + "wp-admin/admin-ajax.php";

    postData( this.path_ajax , datas)
    .then( data => {
        // JSON data parsed by `data.json()` call
        console.log( "data", data );
        console.log( "data", data.data[0] );
        viewDataProducts( data.data[0] );
    })
    .catch( 
        error => { console.error('Error:', error ) }
    );
}

function viewDataProducts( data ) {
    this.data = data;

    input_cantidad.value        = 1;
    input_nombre.value          = this.data.name;
    input_precioxunidad.value   = this.data.precio;
    input_precioxcantidad.value = this.data.precio;

}

button_add.addEventListener('click', function(e) {
    e.preventDefault();

    let temp = {};

    temp = {
        id: Date.now(),
        code: 'temp',
        cantidad: input_cantidad.value,
        nombre: input_nombre.value,
        pricexunit: input_precioxunidad.value,
        pricexcant: input_precioxcantidad.value
    }

    list_product.push( temp );

    clearFormProduct();

    this.temp_subtotal = getSubtotal();
    this.temp_iva      = getIva( this.temp_subtotal );
    this.temp_total    = getTotal( this.temp_subtotal, this.temp_iva );

    append_table.innerHTML = append_table.innerHTML + dataView( temp );

    cont_subtotal.innerHTML = viewSubtotal( this.temp_subtotal );
    cont_iva.innerHTML      = viewIVA( this.temp_iva );
    cont_total.innerHTML    = viewTotal( this.temp_total );

    //setter
    subtotal = this.temp_subtotal;
    iva      = this.temp_iva;
    total    = this.temp_total;

    //event class
    var classname = document.getElementsByClassName('acc-del-product');

    for (i = 0; i < classname.length; i++) {
        classname[i].addEventListener('click', function() {
            this.tmp_id = this.getAttribute('data-id');
            console.log( "tmp_id", this.tmp_id );
            processDelete( this.tmp_id );
            let tmp_html_id = document.getElementById( this.tmp_id );
            tmp_html_id.remove();
            alert("delete");

            console.log( "list", list_product );

        });
    }

});

input_cantidad.addEventListener('keyup', function(e) {
    console.log( 'valor', e.target.value );

    e.target.value = e.target.value.replace(/[^0-9]/g, '');

    this.temp_cant = cantXPrecio( e.target.value, input_precioxunidad.value );
    console.log( "input_precioxunidad", this.temp_cant );
    input_precioxcantidad.value = this.temp_cant;

});

input_precioxunidad.addEventListener('keyup', function(e) {
    console.log( 'valor', e.target.value );

    e.target.value = e.target.value.replace(/[^0-9\.]/g, '');

    this.temp_cant = cantXPrecio( input_cantidad.value, e.target.value );
    console.log( "input_precioxunidad", this.temp_cant );
    input_precioxcantidad.value = this.temp_cant;

});

function cantXPrecio(a, b) { 
    this.a = a;
    this.b = b;
    this.result = 0;

    console.log( input_precioxunidad.value );

    this.a = parseInt( a );
    this.b = parseFloat( b );

    this.result = this.a * this.b;

    return this.result;
 }

 function dataView( data ) {
     this.data = data;
     this.html = `<div id="${data.id}" class="row">
                    <div class="col-2">
                        <div class="row mb-3">
                            <label for="code" class="col-form-label">Codigo</label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="row mb-3">
                            <label for="cantidad" class="col-form-label">${data.cantidad}</label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="row mb-3">
                            <label for="nombre" class="col-form-label">${data.nombre}</label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="row mb-3">
                            <label for="precioxunidad" class="col-form-label">${data.pricexunit}</label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="row mb-3">
                            <label for="precioxcantidad" class="col-form-label">${data.pricexcant}</label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="row mb-3">
                            <button class="btn btn-danger acc-del-product" data-id="${data.id}">Delete</button>
                        </div>
                    </div>
                </div>`;

    

    return this.html;
 }

 function viewSubtotal( subtotal ){
     this.html = `<div class="row">
                        <div class="col-8">
                            Subtotal
                        </div>
                        <div class="col-2">
                            ${subtotal}
                        </div>
                    </div>`;
    return this.html;
 }

 function viewIVA( iva ){
    this.html = `<div class="row">
                        <div class="col-8">
                            IVA
                        </div>
                       <div class="col-2">
                           ${iva}
                       </div>
                   </div>`;
   return this.html;
}

function viewTotal( total ){
    this.html = `<div class="row">
                        <div class="col-8">
                            Total
                        </div>
                       <div class="col-2">
                           ${total}
                       </div>
                   </div>`;
   return this.html;
}

function processDelete( id ) { 
    var tmp_id = id;

    const findID = (element) => element.id == tmp_id;

    this.id_index = list_product.findIndex( findID );

    
    list_product.splice( this.id_index, 1 );

    console.log( "eliminar la posicion", this.id_index );

    //var temp_id = document.getElementById(this.id);


}

function getSubtotal(){
    let tmp_subtotal = 0;
    for (let index = 0; index < list_product.length; index++) {
        console.log( "temp", list_product[index].pricexcant );
        tmp_subtotal = parseFloat(tmp_subtotal) + parseFloat( list_product[index].pricexcant );
    }

    console.log( "temp", tmp_subtotal );

    return tmp_subtotal;
}

function getIva( subtotal ){
    // subtotal = 100
    // x = 16
    return parseFloat(subtotal) * 16 / 100;
}

function getTotal( subtotal, iva ){
    return parseFloat( subtotal + iva );
}

function clearFormProduct() {
    input_cantidad.value        = "";
    input_nombre.value          = "";
    input_precioxunidad.value   = "";
    input_precioxcantidad.value = "";
}
 
 // Ejemplo implementando el metodo POST:
async function postData(url = '', data) {
    // Opciones por defecto estan marcadas con un *
    const response = await fetch(url, {
      method: 'POST', // *GET, POST, PUT, DELETE, etc.
      body: data // body data type must match "Content-Type" header
    })

    return response.json(); // parses JSON response into native JavaScript objects
}