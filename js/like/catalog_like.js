jQuery(document).ready(function() {

    addLike = function(product_Id, store_Id) {
        data = {};
        data["product_Id"] = product_Id;
        data["store_Id"] = store_Id;

        $j.ajax({
            type: "POST",
            url: "/magedoc_like/index/addLike",
            data: JSON.stringify(data),
            dataType: "json",
            success: function(newData){
                if (newData) {
                    console.log(newData);
                    document.getElementById(product_Id).innerHTML= newData;
                    document.getElementById('button'+product_Id).disabled = true;
                } else {
                    document.getElementById('button'+product_Id).disabled = true;
                }
            }
        });
    };
});
