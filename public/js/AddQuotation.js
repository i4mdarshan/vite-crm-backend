/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************************!*\
  !*** ./storage/app/public/js/AddQuotation.js ***!
  \***********************************************/
{
  /* <script type="text/javascript"> */
}
$(function () {
  $(function () {
    $.ajaxSetup({
      headers: {
        "X-CSRF-Token": $('meta[name="_token"]').attr("content")
      }
    });
  }); // var baseURL = process.env.APP_URL;

  var clientSearchURL = "/ajax-autocomplete-search-lead";
  var productSearchURL = "/ajax-autocomplete-search-product"; //initialize select2 for live client search

  var firmURL = "/manage_quotations/get_firm_details";
  $("#live_client_search").select2({
    placeholder: "Select Client",
    dropdownAutoWidth: true,
    width: "auto",
    theme: "bootstrap4",
    selectionCssClass: "form-control form-control-md",
    ajax: {
      url: clientSearchURL,
      dataType: "json",
      delay: 250,
      processResults: function processResults(data) {
        return {
          results: $.map(data, function (item) {
            return {
              text: item.customer_name,
              id: item.id
            };
          })
        };
      },
      cache: true
    }
  }); //initialize select2 for live product search

  $(".select-products").select2({
    placeholder: "Select Product",
    dropdownAutoWidth: true,
    width: "auto",
    selectionCssClass: "form-control form-control-sm",
    theme: "bootstrap4",
    ajax: {
      url: productSearchURL,
      dataType: "json",
      delay: 250,
      processResults: function processResults(data) {
        return {
          results: $.map(data, function (item) {
            return {
              text: item.product_name,
              id: item.id
            };
          })
        };
      },
      cache: true
    }
  }); //add items row on add button click

  $("#add_item").on("click", function () {
    $(".select-products").select2("destroy");
    var noOfRows = $(".product-item-row-0").length;
    console.log(noOfRows);
    var clonedRow = $(".product-item-row-0").first().clone(true);
    clonedRow.insertBefore("#product-item-row-dummy");
    clonedRow.attr("id", "product-item-row-" + noOfRows);
    var set_product_nos = $("#product-item-row-" + noOfRows).children().find('input[id="quotation_product_nos[]"]').val(0);
    var set_product_packaging = $("#product-item-row-" + noOfRows).children().find('input[id="quotation_product_packaging[]"]').val(0);
    var set_quantity = $("#product-item-row-" + noOfRows).children().find('input[id="quotation_product_quantity[]"]').val(0);
    var set_product_per_price = $("#product-item-row-" + noOfRows).children().find('input[id="quotation_product_price[]"]').val(0);
    var set_product_amount = $("#product-item-row-" + noOfRows).children().find('input[id="quotation_product_amount[]"]').val(0);
    $(".select-products").select2({
      placeholder: "Select Product",
      dropdownAutoWidth: true,
      width: "auto",
      selectionCssClass: "form-control form-control-sm",
      theme: "bootstrap4",
      ajax: {
        url: productSearchURL,
        dataType: "json",
        delay: 250,
        processResults: function processResults(data) {
          return {
            results: $.map(data, function (item) {
              return {
                text: item.product_name,
                id: item.id
              };
            })
          };
        },
        cache: true
      }
    });
  }); //delete item row on delete button click

  $(".remRow").on("click", function () {
    var noOfRows = $(".product-item-row-0").length;

    if (noOfRows > 1) {
      var product_amounts = $('input[name="quotation_product_amount[]"]').map(function () {
        return $(this).val();
      }).get(); // console.log("Product amounts array before remove: ", product_amounts);

      $(this).closest("tr").remove();
      var curr_row_id = $(this).parents("tr").attr("id");
    } else {
      return false;
    } //get all product amounts


    var product_amounts = $('input[name="quotation_product_amount[]"]').map(function () {
      return $(this).val();
    }).get();
    console.log("Product amounts array after remove: ", product_amounts); //calculate new subtotal

    var cal_quotation_sub_total = product_amounts.reduce(function (a, b) {
      return parseFloat(a) + parseFloat(b);
    }, 0); //set new subtotal

    var set_quotation_sub_total = $('input[name="quotation_sub_total"]').val(cal_quotation_sub_total.toFixed(2)); // calculate new tax

    var calc_new_tax = (cal_quotation_sub_total * 0.18).toFixed(2); //set new tax

    var set_new_tax = $('input[name="quotation_tax"]').val(calc_new_tax); // calculate new total

    var calc_new_total = parseFloat(cal_quotation_sub_total.toFixed(2)) + parseFloat(calc_new_tax); // set new total

    var set_new_tax = $('input[name="quotation_total"]').val(calc_new_total.toFixed(2));
  }); //function to get firm address in firm change

  $("#firm_name").on("change", function (e) {
    e.preventDefault();
    var firmId = $("#firm_name").val();
    var formData = {
      firm_id: firmId
    };
    $.ajax({
      type: "POST",
      url: firmURL,
      data: formData,
      dataType: "json",
      success: function success(response) {
        //   console.log(response.firm_details.address);
        //push address from response in textarea
        $("#firm_address").html(response.firm_details.address);
      }
    });
  }); // set all the fields as disabled if the product is not selected
  //on select product set packaging and nos

  $(".select-products").on("change", function (e) {
    e.preventDefault();
    var product_id = $(this).val();
    var curr_row_id = $(this).parents("tr").attr("id");
    var set_product_nos = $("#" + curr_row_id).children().find('input[id="quotation_product_nos[]"]').val(1);
    var set_product_packaging = $("#" + curr_row_id).children().find('input[id="quotation_product_packaging[]"]').val(1);
  }); //on product nos of pack input change quantity, product amounts, subtotal, tax calculation and Total calculation

  $('input[id="quotation_product_nos[]"]').on("input", function (e) {
    e.preventDefault();
    var curr_row_id = $(this).parents("tr").attr("id");
    var curr_product_nos = $("#" + curr_row_id).children().find('input[id="quotation_product_nos[]"]').val();

    if (isNaN(curr_product_nos)) {
      curr_product_nos = 0;
    }

    var curr_product_packaging = $("#" + curr_row_id).children().find('input[id="quotation_product_packaging[]"]').val();

    if (isNaN(curr_product_packaging)) {
      curr_product_packaging = 0;
    }

    var calc_quantity = parseInt(curr_product_nos) * parseInt(curr_product_packaging);
    var set_quantity = $("#" + curr_row_id).children().find('input[id="quotation_product_quantity[]"]').val(calc_quantity);
    var curr_price_per_pack = $("#" + curr_row_id).children().find('input[id="quotation_product_price[]"]').val();
    var calc_amount = parseFloat(curr_price_per_pack) * parseInt(curr_product_nos);
    var set_product_amount = $("#" + curr_row_id).children().find('input[id="quotation_product_amount[]"]').val(calc_amount.toFixed(2));
    var initial_quotation_sub_total = 0;
    var initial_total_tax = 0;
    var initial_total_amount = 0; // get initital sub total

    initial_quotation_sub_total = $('input[name="quotation_sub_total"]').val(); //get initial tax amount

    initial_total_tax = $('input[name="quotation_tax"]').val(); //get initial total amount

    initial_total_amount = $('input[name="quotation_total"]').val();

    if (!isNaN(calc_amount)) {
      //get all product amounts
      var product_amounts = $('input[name="quotation_product_amount[]"]').map(function () {
        return $(this).val();
      }).get(); // console.log("current quotation sub total is: ",initial_quotation_sub_total);
      //calculate new sub total with initial sub total

      var cal_quotation_sub_total = product_amounts.reduce(function (a, b) {
        return parseFloat(a) + parseFloat(b);
      }, 0); // set new sub total

      var set_quotation_sub_total = $('input[name="quotation_sub_total"]').val(cal_quotation_sub_total.toFixed(2)); //set new tax

      var calc_new_tax = (cal_quotation_sub_total * 0.18).toFixed(2);
      var set_new_tax = $('input[name="quotation_tax"]').val(calc_new_tax); // set new total

      var calc_new_total = parseFloat(cal_quotation_sub_total.toFixed(2)) + parseFloat(calc_new_tax);
      var set_new_tax = $('input[name="quotation_total"]').val(calc_new_total.toFixed(2));
    } else {
      // set new sub total
      var set_quotation_sub_total = $('input[name="quotation_sub_total"]').val(initial_quotation_sub_total.toFixed(2)); // set old tax value

      var set_old_tax = $('input[name="quotation_tax"]').val(initial_total_tax.toFixed(2)); //set old total amount

      var set_old_total = $('input[name="quotation_tax"]').val(initial_total_amount.toFixed(2));
    }
  }); //on product pack size input,change quantity

  $('input[id="quotation_product_packaging[]"]').on("input", function (e) {
    e.preventDefault();
    var curr_row_id = $(this).parents("tr").attr("id");
    var curr_product_nos = $("#" + curr_row_id).children().find('input[id="quotation_product_nos[]"]').val();

    if (isNaN(curr_product_nos)) {
      var curr_product_nos = 0;
    }

    var curr_product_packaging = $("#" + curr_row_id).children().find('input[id="quotation_product_packaging[]"]').val();

    if (isNaN(curr_product_packaging)) {
      curr_product_packaging = 0;
    }

    var calc_quantity = parseInt(curr_product_nos) * parseInt(curr_product_packaging);
    var set_quantity = $("#" + curr_row_id).children().find('input[id="quotation_product_quantity[]"]').val(calc_quantity);
    var curr_price_per_pack = $("#" + curr_row_id).children().find('input[id="quotation_product_price[]"]').val();

    if (isNaN(curr_price_per_pack)) {
      curr_price_per_pack = 0;
    } // var calc_amount =
    //     parseInt(curr_price_per_pack) * parseInt(curr_product_packaging);
    // var set_product_amount = $("#" + curr_row_id)
    //     .children()
    //     .find('input[id="quotation_product_amount[]"]')
    //     .val(calc_amount.toFixed(2));

  }); //on product price per pack input, update product amount, subtotal, tax calculation and Total calculation

  $('input[id="quotation_product_price[]"]').on("input", function (e) {
    e.preventDefault();
    var price_per_pack = 0; // add NaN check here

    if (!isNaN(e.target.value)) {
      //get entered product per pack value
      var price_per_pack = e.target.value;
    } //get current table row id


    var curr_row_id = $(this).parents("tr").attr("id"); //get current product nos

    var curr_product_nos = $("#" + curr_row_id).children().find('input[id="quotation_product_nos[]"]').val();

    if (isNaN(curr_product_nos)) {
      var curr_product_nos = 0;
    } // calculate product amount using current product packs and price per pack


    var calc_amount = parseFloat(price_per_pack) * parseInt(curr_product_nos); // set calculate product amount for current row

    var set_product_amount = $("#" + curr_row_id).children().find('input[id="quotation_product_amount[]"]').val(calc_amount.toFixed(2)); // console.log("On Product price "+ price_per_pack +" per pack for "+curr_product_nos+" packs change Product amount: "+calc_amount);

    var initial_quotation_sub_total = 0;
    var initial_total_tax = 0;
    var initial_total_amount = 0; // get initital sub total

    initial_quotation_sub_total = $('input[name="quotation_sub_total"]').val(); //get initial tax amount

    initial_total_tax = $('input[name="quotation_tax"]').val(); //get initial total amount

    initial_total_amount = $('input[name="quotation_total"]').val();

    if (!isNaN(calc_amount)) {
      //get all product amounts
      var product_amounts = $('input[name="quotation_product_amount[]"]').map(function () {
        return $(this).val();
      }).get(); // console.log("current quotation sub total is: ",initial_quotation_sub_total);
      //calculate new sub total with initial sub total

      var cal_quotation_sub_total = product_amounts.reduce(function (a, b) {
        return parseInt(a) + parseInt(b);
      }, 0); // set new sub total

      var set_quotation_sub_total = $('input[name="quotation_sub_total"]').val(cal_quotation_sub_total.toFixed(2)); //set new tax

      var calc_new_tax = (cal_quotation_sub_total * 0.18).toFixed(2);
      var set_new_tax = $('input[name="quotation_tax"]').val(calc_new_tax); // set new total

      var calc_new_total = parseFloat(cal_quotation_sub_total.toFixed(2)) + parseFloat(calc_new_tax);
      var set_new_tax = $('input[name="quotation_total"]').val(calc_new_total.toFixed(2));
    } else {
      // set old sub total
      var set_quotation_sub_total = $('input[name="quotation_sub_total"]').val(initial_quotation_sub_total.toFixed(2)); // set old tax value

      var set_old_tax = $('input[name="quotation_tax"]').val(initial_total_tax.toFixed(2)); //set old total amount

      var set_old_total = $('input[name="quotation_tax"]').val(initial_total_amount.toFixed(2));
    }
  });
});
{
  /* </script> */
}
/******/ })()
;