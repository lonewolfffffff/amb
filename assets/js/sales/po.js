$(function() {
    $('#po_items').appendGrid({
        columns: [
            { name:'product',type:'text', display: 'Produk' },
            { name:'quantity',type:'text', display: 'Jumlah' }
        ]
    });
});